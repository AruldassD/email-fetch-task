<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */



    public function fetchEmailInboxes()
    {
        $this->layout = false;
        $this->autoRender = false;

        $this->loadModel('EmailInboxes');
        $this->loadModel('EmailAttachments');
        $this->loadModel('EmailSettings');

        $settings =$this->EmailSettings->find('all')->where(['id' => 1])->first();


        $username = $settings->email;
        $password = $settings->password;

         $imap = imap_open('{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX',$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());


        $emails = imap_search($imap, 'UNSEEN');
        

        if(!empty($emails))
        {
            //put the newest emails on top
            rsort($emails);
            
            foreach($emails as $email_number)
            {
                $flag = 0;
                $mail_data = array();
                $file_name = array();
                $output = array();
                $savefilename = null;
                $filename = null;

                $overview = imap_fetch_overview($imap, $email_number, 0);
                //initialize the subject index with -000, considering not receving this will not be received in
                //subject line of email
                $output['subject'] = '-000x';
                if(isset($overview[0] -> subject))
                {
                    $output['subject'] = $overview[0] -> subject;
                    }

                $structure = imap_fetchstructure($imap, $email_number);
                if(property_exists($structure, 'parts'))
                {
                    $flag = 1;
                    $flattened_parts = $this->flattenParts($structure->parts);
                    foreach($flattened_parts as $part_number => $part)
                    {
                    switch($part->type)
                    {
                        case 0:
                        //the HTML or plain text part of the email
                        if((isset($part->subtype)=='HTML')&&(isset($part->disposition)=='ATTACHMENT'))
                        {
                            $part_number = 1.2;
                        }
                        else if(isset($part->subtype)=='HTML')
                        {
                            $part_number = $part_number;
                        }
                        else
                        {
                            $part_number = $part_number;
                        }               
                        $message = $this->get_part($imap, $email_number, $part_number, $part->encoding);
                        //now do something with the message, e.g. render it
                        break;

                        case 1:
                        // multi-part headers, can ignore
                        break;

                        case 2:
                        // attached message headers, can ignore
                        break;

                        case 3: // application
                        case 4: // audio
                        case 5: // image
                        case 6: // video
                        case 7: // other
                        break;
                    }
                    if(isset($part->disposition))
                    {
                        $filename = $this->getFilenameFromPart($part);
                        if($filename)
                        {
                        // it's an attachment
                        $attachment = $this->get_part($imap, $email_number, $part_number, $part->encoding);

                        $file_info = pathinfo($filename);
                 
                        $file_name[] = $file_info;

                        move_uploaded_file($file_info['basename'], WWW_ROOT . 'uploads' . DS . $file_info['basename']);

                        //This marks message as read
                        }
                        else
                        {
                        
                        }
                    }
                }
            }
            else
            {
                $encoding = $structure->encoding;
                $message = imap_fetchbody($imap, $email_number, 1.2);
              
                if($message == "")
                {
                $message = imap_body($imap, $email_number);
                if($encoding == 3)
                {
                    $message = base64_decode($message);
                }
                else if($encoding == 4)
                {
                    $message = quoted_printable_decode($message);
                }
                }   
            }    
                $header = imap_headerinfo($imap, $email_number);

                $from_email = $header->from[0]->mailbox."@".$header->from[0]->host;
                $to_email = $header->to[0]->mailbox."@".$header->to[0]->host;
                $reply_to_email = $header->reply_to[0]->mailbox."@".$header->reply_to[0]->host;

                $cc_email = array();
                if(isset($header->cc))
                {
                    foreach($header->cc as $ccmail)
                    {
                    $cc_email[] = $ccmail->mailbox.'@'.$ccmail->host;
                    }
                    $cc_email = implode(", ", $cc_email);
                }
                $output['to'] = $to_email;
                $output['from'] = $from_email;
                $output['reply_to'] = $reply_to_email;
                $output['cc'] = $cc_email;

                $formatted_date = date('Y-m-d H:i:s', strtotime($overview[0] -> date));
                $output['uid'] = $overview[0] -> uid;
                $output['date'] = $formatted_date;
                $output['message'] = $message;
                $output['flag'] = $flag;
                $mail_data['Attachment'] = $file_name;
                $mail_data['Data'] = $output;


                $saveInboxData = $this->EmailInboxes->newEntity();

                $saveInboxData->uid = $output['uid'];
                $saveInboxData->email_from = $output['from'];
                $saveInboxData->email_subject = $output['subject'];
                $saveInboxData->date_recieved = $output['date'];
                $saveInboxData->message_body = $output['message'];


                $savedId = $this->EmailInboxes->save($saveInboxData);


                if(!empty($mail_data['Attachment'])){

                    foreach ($mail_data['Attachment'] as $key => $attachment) {
                        

                        $attachments = $this->EmailAttachments->newEntity();

                        $attachments->email_inbox_id = $savedId['id'];

                        $attachments->attachment = $attachment['basename'];

                        $this->EmailAttachments->save($attachments);



                    }

                }

                // pr($mail_data);
            }
        }
        imap_close($imap);

        die;
    }


    function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {

        foreach($messageParts as $part) {
            $flattenedParts[$prefix.$index] = $part;
            if(isset($part->parts)) {
                if($part->type == 2) {
                    $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
                }
                elseif($fullPrefix) {
                    $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
                }
                else {
                    $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix);
                }
                unset($flattenedParts[$prefix.$index]->parts);
            }
            $index++;
        }

        return $flattenedParts;
                
    }


    function get_part($connection, $messageNumber, $partNumber, $encoding) {

        $data = imap_fetchbody($connection, $messageNumber, $partNumber);
        switch($encoding) {
            case 0: return $data; // 7BIT
            case 1: return $data; // 8BIT
            case 2: return $data; // BINARY
            case 3: return base64_decode($data); // BASE64
            case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
            case 5: return $data; // OTHER
        }
        
        
    }

    function getFilenameFromPart($part) {

        $filename = '';
        
        if($part->ifdparameters) {
            foreach($part->dparameters as $object) {
                if(strtolower($object->attribute) == 'filename') {
                    $filename = $object->value;
                }
            }
        }

        if(!$filename && $part->ifparameters) {
            foreach($part->parameters as $object) {
                if(strtolower($object->attribute) == 'name') {
                    $filename = $object->value;
                }
            }
        }
        
        return $filename;
        
    }
}
