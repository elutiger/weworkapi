<?php

namespace Elutiger\Weworkapi\Listeners;

use Elutiger\Weworkapi\Events\EventWeworkNotify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Elutiger\Weworkapi\Message;
use Elutiger\Weworkapi\NewsMessageContent;
use Elutiger\Weworkapi\NewsArticle;
use Elutiger\Weworkapi\TextCardMessageContent;
use Log, Weworkapi;


class SendWeworkNotify
{ 

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
       //
    }

    /**
     * Handle the event.
     *
     * @param  EventWeworkNotify  $event
     * @return void
     */
    public function handle(EventWeworkNotify $event)
    {

        $agent = config('weworkapi.AGENTS.WEWORK_APP_1');  
        
        app('CorpAPI')->init(config('weworkapi.CORP_ID'), $agent['APP_SECRET']);

        //Weworkapi::init(config('weworkapi.CORP_ID'), $agent['APP_SECRET']);

        try { 
            
                $message = $event->notice_data;
                {
                     
                    $message->agentid = $agent['APP_ID']; 
                    
                    if ($event->notice_data->picurl) {

                        $message->messageContent = new NewsMessageContent(
                            array( 
                                 
                                new NewsArticle(
                                    $title = $event->notice_data->title, 
                                    $description = $event->notice_data->description, 
                                    $url = $event->notice_data->url, 
                                    $picurl = !empty($event->notice_data->picurl) ? $event->notice_data->picurl : "http://res.mail.qq.com/node/ww/wwopenmng/images/independent/doc/test_pic_msg1.png", 
                                    $btntxt = $event->notice_data->btntxt
                                )
                            )
                        );
                    } else {

                        $message->messageContent = new TextCardMessageContent(
                            $title = $event->notice_data->title, 
                            $description = $event->notice_data->description, 
                            $url = $event->notice_data->url, 
                            $btntxt = $event->notice_data->btntxt
                        );                        
                    } 
                }
                $invalidUserIdList = null;
                $invalidPartyIdList = null;
                $invalidTagIdList = null;

                app('CorpAPI')->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
                //Weworkapi::MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
                
            } catch (Exception $e) { 
                Log::info($e->getMessage());
            }

    }
     
}
