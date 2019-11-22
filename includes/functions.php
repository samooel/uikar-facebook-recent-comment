<?php
function uikar_fbcomments_main()
{

    $data= '';
    $fbpageID = get_option('FacebookPageID');
    $accessToken = get_option('accessToken');
    if($accessToken && $fbpageID)
    {
        $urlGetPosts = 'https://graph.facebook.com/'.$fbpageID.'/feed?access_token='.$accessToken;
        $postResult = uikar_fbcomment_callAPI('GET', $urlGetPosts, json_encode($data));
        $postresultFul = json_decode($postResult);
        $postsData = $postresultFul->data;
        if($postsData)
        {
            require_once(UIKAR_FBCOMMENTS_BUILDER_DIR . 'includes/links.php');?>
            <header class="product-shower--header clearfix">
                <h3><i class="far fa-chart-bar"></i><?php _e('Facebook Comments', 'uikar-fbcomments');?></h3>
            </header>
            <div class="uikar-fb-comment-holder clearfix">
            <?php
            $counter = 0;
            foreach($postsData as $posts)
            {
                $urlComments = 'https://graph.facebook.com/'.$posts->id.'/comments?access_token='.$accessToken;
                $result = uikar_fbcomment_callAPI('GET', $urlComments, json_encode($data));
                $commentData = json_decode($result);
                $comments = $commentData->data;
                $postCount = get_option('postCounter');
                if(count($comments) > 0 && $counter <= $postCount)
                {
                    foreach($comments as $comment)
                    {
                        if($comment)
                        {
                            $counter++;?>
                            <div class="uikar-fb-comment clearfix">
                                <h3><?php echo($comment->from->name);?></h3>
                                <p><?php echo($comment->message);?></p>
                            </div>
                        <?php }
                    }
                }
            }?>
            </div>
            <?php
        }
    }
    else{
        ?>
        <div class="uikar-fb-comment clearfix">
            <h3><?php _e('You need access token from https://developers.facebook.com and facebook page id ');?></h3>
        </div>
        <?php
    }
}

function uikar_fbcomment_callAPI($method, $url, $data){
    $curl = curl_init();
    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){
        ?>
        <p><?php _e('Connection Failure', 'uikar-fbcomments')?></p>
    <?php
    }
    curl_close($curl);
    return $result;
}
