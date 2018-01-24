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
                                var status_clss = jsonData[i].retweeted ? ' in' : '';
                                var status_value = jsonData[i].retweeted ? 1 : 0;
                                html += '<li><div class="content clearfix"><div class="stream-item-header">';
                                html += '<a href=""><img class="avatar" src="'+ jsonData[i].user.profile_image_url +'">';
                                html += '<span class="fullname">'+ jsonData[i].user.name +'</span><span class="user">&nbsp;@'+ jsonData[i].user.screen_name +'</span></a></div>';
                                html += '<div class="stream-item-content">'+ jsonData[i].text +'</div>';
                                html += '<div class="stream-item-footer"><div><a class="retweet'+status_clss+'" data-id="'+ jsonData[i].id_str +'" data-status="'+status_value+'" href="#" title="Retweet"><i class="glyphicon glyphicon-random"></i></a></div></div>';
                                html += '</div></li>';
                            }
                            $('.stream-items').html(html);
                        });
                        $(document).on('click', '.retweet', function(e){
                            e.preventDefault();
                            var t = $(this), id = t.data('id'), status = t.data('status');
                            $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
                            $.post('/retweet', {id:id, status: status, _token: '{{ csrf_token() }}'}, function(num) {
                                if (num == 1) {
                                    t.addClass('in');
                                    t.data('status', 1);
                                } else if (num == 2)  {
                                    t.data('status', 0);
                                    t.removeClass('in');
                                }
                            });
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
