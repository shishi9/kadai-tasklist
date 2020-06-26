<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{--　トップページへのリンク --}}
        <a class="navbar-brand" href="/">Tasklist</a>
        
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar" >
            <spann class="navbar-toggler-icon"></spann>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                {{-- タスク作成のページへのリンク--}}
                <li class="nav-item">{!! link_to_route('tasks.create','新規タスクの投稿',[],['class' => 'nav-link']) !!}</li>
            </ul>
        </div>
    </nav>
</header>