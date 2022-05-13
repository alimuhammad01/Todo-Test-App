@extends('layouts.app')

@section('content')
    <div class="todoWrap">
        <div class="container">
            <h2>All Users Todo Lists</h2>
            <div class="todoForm">

            </div>
            <div class="todoTabs">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-active-tab" data-bs-toggle="pill" data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active" aria-selected="true">Active</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-completed-tab" data-bs-toggle="pill" data-bs-target="#pills-completed" type="button" role="tab" aria-controls="pills-completed" aria-selected="false">Completed</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-deleted-tab" data-bs-toggle="pill" data-bs-target="#pills-deleted" type="button" role="tab" aria-controls="pills-deleted" aria-selected="false">Deleted</button>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-active" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="myTabsContent">
                            <ul class="taskList">
                                @foreach($active_tasks as $task)
                                    <li class="taskListItem">
                                        <label class="taskListItemLabel">
                                            <input type="checkbox" class="complete_task" name="complete" rel="{{$task->id}}">
                                            <span>{{$task->description}}</span>
                                        </label>

                                        <form action="/admin/task/{{$task->id}}" class="inline-block">
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
                    <div class="tab-pane fade" id="pills-completed" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="myTabsContent">
                            <ul class="taskList">
                                @foreach($completed_tasks as $task)
                                    <li class="taskListItem">
                                        <label class="taskListItemLabel">
                                            <span>{{$task->description}}</span>
                                        </label>

                                        <form action="/admin/task/{{$task->id}}" class="inline-block">
                                            <button type="submit" name="delete" formmethod="POST" class=""><span class="deleteBtn" title="Delete Task"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                            {!! $completed_tasks->links() !!}
                        </div></div>
                    <div class="tab-pane fade" id="pills-deleted" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="myTabsContent">
                            <ul class="taskList">
                                @foreach($deleted_tasks as $task)
                                    <li class="taskListItem">
                                        <label class="taskListItemLabel">
                                            <span>{{$task->description}}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                            {!! $deleted_tasks->links() !!}
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
                                url:"{{ url('admin/update_task_status') }}",
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
