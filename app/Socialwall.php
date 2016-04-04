<?php
/**
* Social with BDD cache
* Instagram     : hashtag
* Twitter       : hashtag
* Facebook      : posts
**/

namespace App\Social;

use App\Database\Database;
use App\Facebook\FacebookConnect;
use Abraham\TwitterOAuth\TwitterOAuth;
use \DateTime;



class Socialwall extends Database{

    private $tag;
    private $fbName;
    private $refreshTime = '1200'; // X minutes * 60 secondes

    public function __construct($tag, $fbName){
        parent::__construct();
        $this->tag      = $tag;
        $this->fbName   = $fbName;
    }


    /**
    * Get all
    **/
    public function getAll(){
        // Secure
        $this->secure();
        // Refresh
        $this->Refresh('instagram', 'setInstagram');
        $this->Refresh('twitter', 'setTwitter');
        $this->Refresh('facebook', 'setFacebook');
        // Select all
        $all = $this->prepare('SELECT *
            FROM socialwall
            WHERE content != "" OR img != ""
            GROUP BY id_social
            ORDER BY date_created DESC', array());

        return $all;
    }

    /**
    * Get Instagram
    **/
    public function getInstagram(){
        // Secure
        $this->secure();
        // Refresh
        $this->Refresh('instagram', 'setInstagram');
        // Select all items
        $results = $this->searchItems('instagram');
        return $results;
    }

    /**
    * Get Twitter
    **/
    public function getTwitter(){
        // Secure
        $this->secure();
        // Refresh
        $this->Refresh('twitter', 'setTwitter');
        // Select all items
        $results = $this->searchItems('twitter');
        return $results;
    }

    /**
    * Get Facebook
    **/
    public function getFacebook(){
        // Secure
        $this->secure();
        // Refresh
        $this->Refresh('facebook', 'setFacebook');
        //if(empty($_SESSION['fb_token'])) $this->setFacebook();
        // Select all items
        $results = $this->searchItems('facebook');
        return $results;
    }


    /**
    * Instagram Settings
    **/
    private function setInstagram($client_id = '__REPLACE_THIS__ID_CLIENT__', $client_secret = '__REPLACE_THIS__ID_SECRET__'){

        $url    = 'https://api.instagram.com/v1/tags/'.$this->tag.'/media/recent?client_id='.$client_id;
        $json   = file_get_contents($url);

        if ($json) {
            $datas = json_decode($json);
            foreach($datas->data as $obj) {
                $id_social = $obj->id;
                $date_created   =  Date('Y-m-d H:i:s', $obj->created_time);
                $username       = $obj->caption->from->username;
                $content        =  $obj->caption->text;
                $img            = "";
                $link           = "";
                $likes          = "";
                $rt             = "";
                if(!empty($obj->images) && $obj->images->standard_resolution) $img = $obj->images->standard_resolution->url;
                if(!empty($obj->link)) $link = $obj->link;
                if($obj->likes->count > 0) $likes = $obj->likes->count;;

                $this->setSocial('instagram',  $id_social, $date_created, $username, $content, $img, $link, $likes, $rt);
            }
        }
    }

    /**
    * Twitter Settings
    **/
    private function setTwitter(){
        $consumerKey        = '__REPLACE_THIS__CONSUMER_KEY__';
        $consumerSecret     = '__REPLACE_THIS__CONSUMER_KEY_SECRET__';
        $accessToken        = '__REPLACE_THIS__ACCESS_TOKEN__';
        $accessTokenSecret  = '__REPLACE_THIS__ACCESS_TOKEN_SECRET__';

        $oauth      = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
        $tweets     = $oauth->get('search/tweets', ['q' => $this->tag, 'include_entities' => true]);

        foreach($tweets->statuses as $obj) {
            $id_social      = $obj->id_str;
            $date_created   = Date('Y-m-d H:i:s', strtotime($obj->created_at));
            $username       = $obj->user->name;
            $content        = $obj->text;
            $img            = "";
            $link           = "";
            $likes          = "";
            $rt             = "";
            if(!empty($obj->entities->media[0]->media_url)) $img = $obj->entities->media[0]->media_url;
            if(!empty($obj->entities->urls[0]->url)){
                $link = $obj->entities->urls[0]->url;
            } elseif(!empty($obj->entities->media[0]->url)){
                $link = $obj->entities->media[0]->url;
            } elseif(!empty($obj->retweeted_status->entities->urls[0]->url)){
                $link = $obj->retweeted_status->entities->urls[0]->url;
            } elseif(!empty($obj->retweeted_status->entities->media[0]->url)){
                $link = $obj->retweeted_status->entities->media[0]->url;
            } else{
                $link = "http://twitter.com/".$obj->user->screen_name;
            }
            if($obj->favorite_count > 0) $likes = $obj->favorite_count;
            if($obj->retweet_count > 0) $rt = $obj->retweet_count;

            $this->setSocial('twitter',  $id_social, $date_created, $username, $content, $img, $link, $likes, $rt);
        }
    }

    /**
    * Facebook Settings
    **/
    private function setFacebook(){
            $appId      = '__REPLACE_THIS__APP_ID__';
            $appSecret  = '__REPLACE_THIS__APP_SECRET__';
            $appToken   = '__REPLACE_THIS__APP_TOKEN__';

            $_SESSION['fb_token'] = $appToken;

            $connect    = new FacebookConnect($appId, $appSecret);
            $user       = $connect->connect('__REPLACE_THIS__URL_CONNECT__');

            $url        = "https://graph.facebook.com/".$this->fbName."/feed?access_token=".$appToken;
            $json       = file_get_contents($url);
            $datas      = json_decode($json);

            foreach($datas->data as $obj){
                $img            = "";
                if(!empty($obj->object_id)){
                    $img        = 'https://graph.facebook.com/'.$obj->object_id.'/picture?type=normal';
                }
                $id_social      = md5($obj->id.":".$obj->created_time);
                $date_created   = Date('Y-m-d H:i:s', strtotime($obj->created_time));
                $username       = $obj->from->name;
                $content        = "";
                $link           = "";
                $likes          = "";
                $rt             = "";
                if(isset($obj->message)) $content = $obj->message;
                if(isset($obj->link)) $link = $obj->link;

                $this->setSocial('facebook',  $id_social, $date_created, $username, $content, $img, $link, $likes, $rt);
            }


            $url = "https://graph.facebook.com/".$this->fbName."/posts?access_token=".$appToken;
            $json = file_get_contents($url);
            $datas = json_decode($json);

            foreach($datas->data as $obj){
                  $img          = "";
                if(!empty($obj->object_id)){
                    $img        = 'https://graph.facebook.com/'.$obj->object_id.'/picture?type=normal';
                }
                $id_social      = md5($obj->id.":".$obj->created_time);
                $date_created   = Date('Y-m-d H:i:s', strtotime($obj->created_time));
                $username       = $obj->from->name;
                $content        = "";
                $link           = "";
                $likes          = "";
                $rt             = "";
                if(isset($obj->message)) $content = $obj->message;
                if(isset($obj->link)) $link = $obj->link;

                $this->setSocial('facebook',  $id_social, $date_created, $username, $content, $img, $link, $likes, $rt);
            }
    }


    /**
    * PERSONNAL FUNCTION
    **/

    /**
    * Search
    **/
    private function searchItems($source){
        return $this->prepare('SELECT *
            FROM socialwall
            WHERE source = :source
            ORDER BY date_created DESC',
            array( 'source' => $source ));
    }

    /**
    * Set Social
    **/
    private function setSocial($source, $id_social, $date_created, $username, $content, $img, $link, $likes, $rt){
        // Search post exist
        $search = $this->prepare('SELECT id_social
            FROM socialwall
            WHERE id_social = :id_social
            LIMIT 1',
            array(
                'id_social' => $id_social
            ));
        // Update
        if(!empty($search)){
            $update = $this->prepare('UPDATE socialwall
                SET username = :username, content = :content,  img = :img, link = :link, likes = :likes, rt = :rt
                WHERE id_social = :id_social',
            array(
                'id_social'     => $id_social,
                'username'      => $username,
                'content'       => $content,
                'img'           => $img,
                'link'          => $link,
                'likes'         => $likes,
                'rt'            => $rt
            ));
        // Insert
        } else{
            if(!empty($img) || !empty($content)){
                $insert = $this->prepare('INSERT INTO socialwall(id_social, date_created, username, content, img, link, likes, rt, source)
                    VALUES (:id_social, :date_created, :username, :content, :img, :link, :likes, :rt, :source)',
                array(
                    'id_social'     => $id_social,
                    'date_created'  => $date_created,
                    'username'      => $username,
                    'content'       => $content,
                    'img'           => $img,
                    'link'          => $link,
                    'likes'         => $likes,
                    'rt'            => $rt,
                    'source'        => $source
                ));
            }
        }
    }

    /**
    * Refresh
    **/
    private function Refresh($source, $method){
        // Time to refresh -> $refreshTime
        $refresh            = $this->prepare('SELECT * FROM socialrefresh WHERE source = :source LIMIT 1',
            array( 'source' => $source ),
            'refreshdate', true);
        $datenow            = new DateTime();
        $datelastrefresh    = DateTime::createFromFormat('Y-m-d H:i:s', $refresh['last_refresh']);
        $timerefresh        = ($datenow->format('U') - $datelastrefresh->format('U'));
        // Update refresh in all x secondes
        if($timerefresh > $this->refreshTime){
            $updaterefresh  = $this->prepare('UPDATE socialrefresh
                    SET last_refresh = :last_refresh
                    WHERE source = :source',
                array(
                    'last_refresh'  => Date('Y-m-d H:i:s'),
                    'source'        => $source
                ));
            $this->$method();
        }
    }

    /**
    * Delete duplicate
    **/
    private function secure(){
        $delDuplicate = $this->query('DELETE t1
            FROM socialwall AS t1, socialwall AS t2
            WHERE t1.id > t2.id
            AND   t1.id_social = t2.id_social
            AND   t1.date_created = t2.date_created
            AND   t1.username = t2.username
            AND   t1.content = t2.content
            AND   t1.source = t2.source');
        $delEmpty = $this->query('DELETE FROM socialwall
            WHERE content = "" AND img = ""');
    }




}