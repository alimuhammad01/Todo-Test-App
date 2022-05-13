@extends('layouts.app')

@section('content')
    <div class="todoWrap">
        <div class="container">
            <h2>My Todo List</h2>
            <div class="todoForm">
                <form method="POST" action="/task">
                    <label style="display: inline-block;">
                        <input placeholder="Add new task" name="description"/>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </label>
                    <button class="todoBtn" type="submit" style="float: right;">Add</button>

                    {{ csrf_field() }}
                </form>

            </div>
            <div class="todoTabs">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Active</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Completed</button>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="myTabsContent">
                            <ul class="taskList">
                                @foreach($active_tasks as $task)
                                    <li class="taskListItem">
                                        <label class="taskListItemLabel">
                                            <input type="checkbox" class="complete_task" name="complete" rel="{{$task->id}}">
                                            <span>{{$task->description}}</span>
                                        </label>

                                        <form action="/task/{{$task->id}}" class="inline-block">
                                            <button type="submit" name="delete" formmethod="POST" class=""><span class="deleteBtn" title="Delete Task"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                            {!! $active_tasks->links() !!}
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="myTabsContent">
                            <ul class="taskList">
                                @foreach($complete_tasks as $task)
                                    <li class="taskListItem">
                                        <label class="taskListItemLabel">
                                            <span>{{$task->description}}</span>
                                        </label>

                                        <form action="/task/{{$task->id}}" class="inline-block">
                                            <button type="submit" name="delete" formmethod="POST" class=""><span class="deleteBtn" title="Delete Task"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                            {!! $complete_tasks->links() !!}
                        </div></div>
                </div>


            </div>
        </div>
    </div>

@endsection
@section('page-js-script')
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $(document).on("click", ".complete_task", function(e) {
                e.preventDefault();
                var id = $(this).attr('rel');
                bootbox.confirm({
                    message: "Are you sure that you want to make this task as done ?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function(result) {
                        if (result) {
                            $.ajax({
                                type:'POST',
                                url:"{{ url('update_task_status') }}",
                                data:{id:id},
                                success:function(data){
                                    location.reload();
                                }
                            });
                        } else {
                        }
                    }
                });

            });
        });
    </script>
@stop
