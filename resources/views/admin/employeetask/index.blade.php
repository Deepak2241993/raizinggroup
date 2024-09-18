@extends('layouts.masteradmin')
@section('body')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Responsive Table</h4>
                <p class="card-title-desc">
                    Create responsive tables by wrapping any <code>.table</code> in <code>.table-responsive</code>
                    to make them scroll horizontally on small devices (under 768px).
                </p>

                <div class="table-responsive">
                  Employee All Task  
                  {{-- @if(Auth::user()->type!='Employee')
                  <a class="btn btn-primary" href="{{route('employeetask.create')}}">Add Task</a>
                  @endif --}}
                    @if(session('message')) <p style="color:rgb(6, 82, 6); font-weight: 600;">{{session('message')}}</p>@endif
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Task Title</th>
                                <th>Assign Date</th>
                                <th>File</th>
                                <th>Task Details</th>
                                <th>Status</th>
                                @if(Auth::user()->type=='master_admin')
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $value)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$value->emp_name}}</td>
                                <td>{{$value->t_title}}</td>
                                <td>{{$value->assign_date}}</td>
                                <td>
                                    @if(!empty($value->t_file))
                                    <a href="{{url('/images/'.$value->t_file)}}" target="_blank" download>Download File</a>
                                    @endif
                                </td>
                                <td>{{$value->t_detail}}</td>
                                
                                
                                <td><div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    {{-- <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd{{$value->id}}" @if($value->status==1){{'checked'}} @endif> --}}
                                    
                                    <label class="form-check-label" for="SwitchCheckSizemd{{$value->id}}">
                                         <button class="btn btn-@if($value->status=='0'){{"danger"}}@elseif( $value->status=='2'){{"warning"}}@else{{"success"}} @endif">
                                            @if( $value->status=='0') {{"To Do"}} @elseif( $value->status=='2') {{"In Progress"}} @else {{"Completed"}} @endif</button>
                                        
                                         </label>
                                    </div>
                                </td>
                               
                                <td>
                                    <div class="button_align">
                                        <a href="{{route('employeetask.edit',$value->id)}}" class="btn btn-outline-primary"><i class="bx bx-pencil"></i> View Task </a> 
                                       
                                        @if($usertype=Auth::user()->type =='master_admin')
                                        <a href="javascript:void(0);"  onClick="deletetasks('{{$value->id}}')" class="btn btn-outline-danger"><i class="bx bx-trash-alt"></i> Delete</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{$data->links('vendor.pagination.simple-bootstrap-4')}}
                
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-section-code')

<script>
    function deletetasks(tid){
        if(confirm('Are You sure'))
        {
        $.ajax({
            method:'DELETE',
            url: '{{ url('master-admin/employeetask') }}/'+tid,
            data:{
                id: tid,
                _token: '{{ csrf_token() }}'
            },
            success:function(response){
                
                if(response.success==true)
                {
                    location.reload();
                    swal("Success!", response.message, "success");
                    

                }
                if(response.success==false)
                {
                    location.reload();
                    swal("Deleted!", response.message, "error");
                    

                }
                
            }
        });
    }
}
    function update_status(tid){
        if(confirm('Do you want to change status'))
        {
        $.ajax({
            method:'POST',
            url: '{{ url('master-admin/employee_task_update/') }}/'+tid,
            data:{
                id: tid,
                _token: '{{ csrf_token() }}'
            },
            success:function(response){
                
                if(response.success)
                {
                    location.reload();
                    swal("Deleted!", "Status Updated Successfully!", "success");

                }
                
            }
        });
    }
}
    </script>


@endpush