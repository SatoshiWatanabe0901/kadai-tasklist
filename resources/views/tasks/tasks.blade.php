@if (count($tasks) > 0)
    <ul class='list-unstyled'>
        @foreach($tasks as $task)
            <li class='media mb-12'>
                <div class='media-body'>
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>タスクID</th>
                                <th>ステータス</th>
                                <th>タスク</th>
                            </tr>
                        </thead>
                        <tbody>            
                            <tr>
                                <td>
                                    <div>
                                        {{-- タスクの所有者のユーザ詳細ページへのリンク --}}
                                        {!! link_to_route('users.show', $task->id, ['user' => $task->id]) !!}
                                        <span class='text=muted'>posted at {{ $task->created_at }}</span>
                                    </div>
                                </td>
                                <div>
                                    {{-- 投稿内容 --}}
                                    <td><p class='mb-0'>{!! nl2br(e($task->status)) !!}</p></td>
                                    <td><p class='mb-0'>{!! nl2br(e($task->content)) !!}</p></td>
                                </div>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </li>
        @endforeach
    </ul>
    {{ $tasks->links() }}
@endif

