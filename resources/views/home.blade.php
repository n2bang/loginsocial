@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    <ul class="stream-items">
                        <!--li>
                            <div class="content">
                                <div class="stream-item-header">
                                    <a href="">
                                        <img class="avatar" src="http://pbs.twimg.com/profile_images/874276197357596672/kUuht00m_normal.jpg">
                                        <span class="fullname">Duy Nguyen</span>
                                        <span class="user">@DuyNguyen</span>
                                    </a>
                                </div>
                                <div class="stream-item-content">
                                    <p>Not looking good for our great Military or Safety & Security on the very dangerous Southern Border. Dems want a Shu… https://t.co/Zs62ydrvwQ</p>
                                </div>
                                <div class="stream-item-footer">
                                    
                                </div>
                            </div>
                        </li-->
                    </ul>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        // $.get('/homeTimeline', function(data){
                        //     var jsonData = JSON.parse(data);
                        //     // console.log(jsonData[0].user);
                        //     var html = '';
                        //     for (var i = 0; i < jsonData.length; i++) {
                        //         html += '<li><div class="content clearfix"><div class="stream-item-header">';
                        //         html += '<a href=""><img class="avatar" src="'+ jsonData[i].user.profile_image_url +'">';
                        //         html += '<span class="fullname">'+ jsonData[i].user.name +'</span><span class="user">&nbsp;@'+ jsonData[i].user.screen_name +'</span></a></div>';
                        //         html += '<div class="stream-item-content">'+ jsonData[i].text +'</div>';
                        //         html += '<div class="stream-item-footer"><div class="retweet"><a href="" title="Retweet"><i class="glyphicon glyphicon-random"></i></a></div></div>';
                        //         html += '</div></li>';
                        //     }
                        //     $('.stream-items').html(html);
                        // });
                    });
                </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
