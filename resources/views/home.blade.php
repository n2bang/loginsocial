@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                @if (Auth::check())
                    <ul class="stream-items">
                    </ul>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $.get('/homeTimeline', function(data){
                            var jsonData = JSON.parse(data);
                            var html = '';
                            for (var i = 0; i < jsonData.length; i++) {
                                html += '<li><div class="content clearfix"><div class="stream-item-header">';
                                html += '<a href=""><img class="avatar" src="'+ jsonData[i].user.profile_image_url +'">';
                                html += '<span class="fullname">'+ jsonData[i].user.name +'</span><span class="user">&nbsp;@'+ jsonData[i].user.screen_name +'</span></a></div>';
                                html += '<div class="stream-item-content">'+ jsonData[i].text +'</div>';
                                html += '<div class="stream-item-footer"><div class="retweet"><a href="" title="Retweet"><i class="glyphicon glyphicon-random"></i></a></div></div>';
                                html += '</div></li>';
                            }
                            $('.stream-items').html(html);
                        });
                    });
                    </script>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
