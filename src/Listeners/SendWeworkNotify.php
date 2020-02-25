<?php

namespace Elutiger\Weworkapi\Listeners;

use Elutiger\Weworkapi\Events\EventWeworkNotify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Elutiger\Weworkapi\Datastructure\Message;
use Elutiger\Weworkapi\NewsMessageContent;
use Elutiger\Weworkapi\NewsArticle;
use Elutiger\Weworkapi\TextCardMessageContent;
use App;
use Log;

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
     * @param  EventVipCardUpdated  $event
     * @return void
     */
    public function handle(EventWeworkNotify $event)
    {
        /*
         * Copyright (C) 2017 All rights reserved.
         *
         * @File MessageTest.php
         * @Brief
         * @Author abelzhu, abelzhu@tencent.com
         * @Version 1.0
         * @Date 2017-12-26
         *
         */


        $agentId    = $event->notice_data->agentId;
        $data       = $event->notice_data->data;

        $api = App::make("CorpAPI");
        $api->init($agentId, config('weworkapi.apps.'.$agentId.'.Secret'));

        $appName = config('weworkapi.apps.'.$agentId.'.appName');
        $appType = config('weworkapi.apps.'.$agentId.'.appType');
        switch ($appType) {
            case 'internal_program':
                try {
                        $message = new Message();
                        {
                            $message->sendToAll = false;
                            $message->touser    = !is_null($event->notice_data->toUser) ? $event->notice_data->toUser : config('weworkapi.apps.'.$agentId.'.toUser');
                            $message->toparty   = !is_null($event->notice_data->toParty) ? $event->notice_data->toParty : config('weworkapi.apps.'.$agentId.'.toParty');
                            $message->totag     = !is_null($event->notice_data->toTag) ? $event->notice_data->toTag : config('weworkapi.apps.'.$agentId.'.toTag');
                            $message->agentid   = $agentId;
                            $message->safe      = 0;

                            // $message->messageContent = new NewsMessageContent(
                            //     array(
                            //         new NewsArticle(
                            //             $title = "中秋节礼品领取",
                            //             $description = "今年中秋节公司有豪礼相送",
                            //             $url = "https://work.weixin.qq.com/wework_admin/ww_mt/agenda",
                            //             $picurl = "http://res.mail.qq.com/node/ww/wwopenmng/images/independent/doc/test_pic_msg1.png",
                            //             $btntxt = "btntxt"
                            //         ),
                            //     )
                            // );

                            $message->messageContent = new TextCardMessageContent(
                                $title          = $event->notice_data->title,
                                $description    = $event->notice_data->description,
                                $url            = $event->notice_data->url,
                                $btntxt         = $event->notice_data->btntxt
                            );
                        }
                        $invalidUserIdList = null;
                        $invalidPartyIdList = null;
                        $invalidTagIdList = null;

                        Log::info('appName:'.$appName.':'.$api->GetAccessToken());
                        $api->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
                        // var_dump($invalidUserIdList);
                        // var_dump($invalidPartyIdList);
                        // var_dump($invalidTagIdList);
                } catch (Exception $e) {
                    Log::info($e->getMessage());
                }
                break;
            case 'app_program':
                try {
                        Log::info('appName:'.$appName.':'.$api->GetAccessToken());
                        $api->SendMessage($data);
                } catch (Exception $e) {
                    Log::info($e->getMessage());
                }
                break;

            case 'miniprogram':
                try {
                        Log::info('appName:'.$appName.':'.$api->GetAccessToken());
                        $api->SendMessage($data);
                } catch (Exception $e) {
                    Log::info($e->getMessage());
                }
                break;

            default:
                # code...
                break;
        }
    }
}
