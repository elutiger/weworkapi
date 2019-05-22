## About 

**elutiger/weworkapi** 是**[weworkapi_php](https://github.com/sbzhu/weworkapi_php)** (official lib of wework api https://work.weixin.qq.com/api/doc) 在laravel下的安装包，支持laravel5.5以上版本测试使用。本库仅做示范用，并不保证完全无bug；另外，作者会不定期更新本库，但不保证与官方API接口文档同步，因此一切以官方文档为准。

## Install
**step 1**: $ composer require elutiger/weworkapi-for-laravel5 "dev-master"

**step 2**: $ php artisan vendor:publish --provider "Elutiger/WeworkapiServiceProvider"

change the config in the generated file "config/weworkapi.php"

	// 请将下面参数改为自己的企业相关参数再进行测试

	return array (
    // 企业的id，在管理端->"我的企业" 可以看到
    "CORP_ID"               => "ww4b7f2b843202****",

    // "通讯录同步"应用的secret, 开启api接口同步后，可以在管理端->"通讯录同步"看到
    "CONTACT_SYNC_SECRET"   => "RGVi7yFu5BzM00ijo20CR2SRYJKYQoGrAHyr_GSrT58",

    // 某个自建应用的id及secret, 在管理端 -> 企业应用 -> 自建应用, 点进相应应用可以看到
    "APP_ID"                => 1000002,
    "APP_SECRET"            => "Q0yAyQhZ2pXt12pcMRq36g1dbrEci028GTVIDNyKqLg",

    // 打卡应用的 id 及secrete， 在管理端 -> 企业应用 -> 基础应用 -> 打卡，
    // 点进去，有个"api"按钮，点开后，会看到
    "CHECKIN_APP_ID"        => 3010011,
    "CHECKIN_APP_SECRET"    => "UiaHraIs_CULvovHDyiaBjODrfsWzXGmZtWcPr8JIbA",

    // 审批应用的 id 及secrete， 在管理端 -> 企业应用 -> 基础应用 -> 审批，
    // 点进去，有个"api"按钮，点开后，会看到
    "APPROVAL_APP_ID"       => 3010040,
    "APPROVAL_APP_SECRET"   => "R79l0DKnrALsIK5J_DcjU7TzP-ipCjFKYOzBs53IC80",
);

**step 3**: add facade alias to the config file "config/app.php", in the case add code lines to the aliases array like below 

 'Weworkapi' => Elutiger\Weworkapi\Facades\Weworkapi::class,
 
## Usage
	use Log;
	use Weworkapi;
	use Elutiger\Weworkapi\Message;
	use Elutiger\Weworkapi\NewsMessageContent;
	use Elutiger\Weworkapi\NewsArticle;

	////////////////////////////////////////////////////////////

	$agentId = config('weworkapi.APP_ID');
		 
        try { 
            
                $message = new Message();
                {
                    $message->sendToAll = false;
                    $message->touser = ['userid'];
                    $message->toparty = [];
                    $message->totag = [];
                    $message->agentid = $agentId;
                    $message->safe = 0;

                    $message->messageContent = new NewsMessageContent(
                        array( 
                             
                            new NewsArticle(
                                $title = $event->notice_data->title, 
                                $description = $event->notice_data->description, 
                                $url = $event->notice_data->url, 
                                $picurl = "http://res.mail.qq.com/node/ww/wwopenmng/images/independent/doc/test_pic_msg1.png", 
                                $btntxt = $event->notice_data->btntxt
                            )
                        )
                    );

                    /*$message->messageContent = new \TextCardMessageContent(
                            $title = $event->notice_data->title, 
                            $description = $event->notice_data->description, 
                            $url = $event->notice_data->url, 
                            $btntxt = $event->notice_data->btntxt
                    );*/
                }
                $invalidUserIdList = null;
                $invalidPartyIdList = null;
                $invalidTagIdList = null;

                Weworkapi::MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
                
                
            } catch (Exception $e) { 
                Log::info($e->getMessage());
            }

 
