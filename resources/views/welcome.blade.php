<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @extends('layouts.app')
                
            @section('content')
                    @if (Auth::check())
                        <div class='row'>
                            <aside class='col-sm-12'>
                                <h3 class='card-title'>{{ Auth::user()->name }}さんのタスク</h3>
                            </aside>
                            <div class='col-sm-8'>
                                {{--タスク一覧--}}

                                @include('tasks.index')
                            </div>
                        </div>
                        {{--タスク作成ページへのリンク--}}
                        {!! link_to_route('tasks.create', '新規タスクの投稿', [], ['class' => 'btn btn-primary']) !!}
                    @else
                        <div class='center jumbotron'>
                            <div class='text-center'>
                                <h1>Welcome to the Tasklist</h1>
                                {{-- ユーザ登録ページへのリンク --}}
                                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
                            </div>
                        </div>
                    @endif
            @endsection
            </div>
        </div>
    </body>
    
</html>
