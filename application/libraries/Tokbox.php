<?php
defined('BASEPATH') || exit('No direct script access allowed');

use OpenTok\OpenTok;
use OpenTok\Session;
use OpenTok\Stream;
use OpenTok\StreamList;
use OpenTok\Archive;
use OpenTok\Broadcast;
use OpenTok\Layout;
use OpenTok\Role;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\OutputMode;
use OpenTok\Util\Client;
use OpenTok\Util\Validators;
use OpenTok\Exception\UnexpectedValueException;
use OpenTok\Exception\InvalidArgumentException;

/**
 * Description of Tokbox Library
 *
 * @category libraries
 *
 * @package libraries
 *
 * @module Video Chat
 *
 * @class Tokbox.php
 *
 * @path application\libraries\Tokbox.php
 *
 * @version 4.0
 *
 * @author CIT Dev Team
 *
 * @since 01.08.2016
 */
class Tokbox
{

    protected $CI;
    public $opentok;

    public function __construct($auth = array())
    {
        $this->CI = &get_instance();
        require(APPPATH . "third_party/tokbox/vendor/autoload.php");
        $apiKey = $this->CI->config->item('TOKBOX_PROJECT_API_KEY'); // 46243592
        $apiSecret = $this->CI->config->item('TOXBOX_PROJECT_SECRET'); //4a2cfff6bbb0f94f62de590a7cbbf1513ad3f827


        $this->opentok = new OpenTok($apiKey, $apiSecret);
    }

    public function createSession()
    {
        // An automatically archived session:
        $sessionOptions = array(
            'mediaMode' => MediaMode::ROUTED
        );
        $session = $this->opentok->createSession($sessionOptions);
        $sessionId = $session->getSessionId();
        return $sessionId;
    }

    public function generateToken($sessionId, $metadata = '')
    {
        $options = array('data' => $metadata);
        // print_r($options);
        // die;
        try {
            $token = $this->opentok->generateToken($sessionId, $options);
            // echo $token . '<br>';
            // print_r($options);
            if (substr($token, -1) === '=') {
                $token = substr($token, 0, -1);
            }

            // die;
            return $token;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function startArchive($sessionId, $name)
    {
        // Create a simple archive of a session
        //$archive = $this->opentok->startArchive($sessionId);
        // Create an archive using custom options
        $archiveOptions = array(
            'name' => $name,     // default: null
            'hasAudio' => true,                     // default: true
            'hasVideo' => true,                     // default: true
            'outputMode' => OutputMode::COMPOSED,   // default: OutputMode::COMPOSED
            'resolution' => '1280x720'              // default: '640x480'
        );
        $archive = $this->opentok->startArchive($sessionId, $archiveOptions);
        // Store this archiveId in the database for later use
        $archiveId = $archive->id;
        return $archiveId;
    }

    public function stopArchive($archiveId)
    {
        // Stop an Archive from an archiveId (fetched from database)
        $archive =  $this->opentok->stopArchive($archiveId);

        return array('id' => $archive->id, 'status' => $archive->status, 'url' => $archive->url);
    }

    public function getArchive($archiveId)
    {
        $archive = $this->opentok->getArchive($archiveId);
        // pr($archive);
        $url_arr = explode('?', $archive->url);
        return array('id' => $archive->id, 'status' => $archive->status, 'url' => $url_arr[0]);
    }

    public function deleteArchive($archiveId)
    {
        // Delete an Archive from an archiveId (fetched from database)
        return $this->opentok->deleteArchive($archiveId);
    }

    public function listArchives()
    {
        $archiveList = $this->opentok->listArchives();
        // Get an array of OpenTok\Archive instances
        $archives = $archiveList->getItems();
        // Get the total number of Archives for this API Key
        $totalCount = $archiveList->totalCount();
        $return_arr = array();
        $return_arr['archives'] = (array)$archives;
        $return_arr['totalCount'] = $totalCount;
        return $return_arr;
    }

    public function listStreams($sessionId)
    {
        $streamList = $this->opentok->listStreams($sessionId);
        $totalCount = $streamList->totalCount(); // total count
        $return_arr = array();
        $return_arr['archives'] = (array)$streamList;
        $return_arr['totalCount'] = $totalCount;
        return $return_arr;
    }
}

/* End of file Nexmo.php */
/* Location: ./application/libraries/Nexmo.php */
