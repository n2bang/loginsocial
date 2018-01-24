@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Twitter API</div>
                <form action="/tweet" method="post" style="padding: 10px" enctype="multipart/form-data">
                    <div class="form-group">
                        <textarea name="tweet" maxlength="160" class="form-control" placeholder="Twitter Text"></textarea>
                        @if ($errors->has('tweet'))
                        <div class="error">{{ $errors->first('tweet') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="images[]" multiple="" accept="image/gif,image/jpeg,image/jpg,image/png,video/mp4,video/x-m4v">
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-default">Tweet</button>
                </form>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                @if (Auth::check())
                    <ul class="stream-items">
                    </ul>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $.get('/homeTimeline', function(data){
                            var jsonData = JSON.parse(data);
                            console.log(jsonData[0]);
                            var html = '';
                            for (var i = 0; i < jsonData.length; i++) {
                                html += '<li><div class="content clearfix"><div class="stream-item-header">';
                                html += '<a href=""><img class="avatar" src="'+ jsonData[i].user.profile_image_url +'">';
                                html += '<span class="fullname">'+ jsonData[i].user.name +'</span><span class="user">&nbsp;@'+ jsonData[i].user.screen_name +'</span></a></div>';
                                html += '<div class="stream-item-content">'+ jsonData[i].text +'</div>';
                                html += '<div class="stream-item-footer"><div class="retweet"><a data-id="'+ jsonData[i].id +'" href="#" title="Retweet"><i class="glyphicon glyphicon-random"></i></a></div></div>';
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
