@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('includes.alert')
            <section class="panel">
                <header class="panel-heading clearfix">
                    {{ $title }}
                    <span class="pull-right">
                            <a class="btn btn-success btn-sm btn-new-user" href="{{ URL::route('reward.create') }}">Add Reward</a>
                    </span>
                </header>
                
                <div class="panel-body">
                    @if(count($rewards))
                        <table class="display table table-bordered table-striped" id="example">
                            <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Fine</th>
                                <th>Extra Payment</th>                   
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rewards as $reward)
                                <tr>
                                    <td>{{ $reward->user->employeeID }}</td>
                                    <td>{{ $reward->fine}}</td>
                                    <td>{{ $reward->extra_pay}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success btn-edit" href="{{ URL::route('reward.edit', array('id' => $reward->id)) }}">Edit</a>
                                        <!--a href="#" class="btn btn-danger btn-xs btn-archive deleteBtn" data-toggle="modal" data-target="#deleteConfirm" deleteId="{{ $reward->id }}">Delete</a-->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        No Data Found
                    @endif
                </div>
            </section>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                    Are you sure to delete?
                </div>
                <div class="modal-footer">
                    {{ Form::open(array('route' => array('reward.delete', 0), 'method'=> 'delete', 'class' => 'deleteForm')) }}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    {{ Form::submit('Yes, Delete', array('class' => 'btn btn-success')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


@stop


@section('style')
    {{ HTML::style('assets/data-tables/DT_bootstrap.css') }}

@stop


@section('script')
    {{ HTML::script('assets/data-tables/jquery.dataTables.js') }}
    {{ HTML::script('assets/data-tables/DT_bootstrap.js') }}

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            
            $('#example').dataTable({
            });

            $(document).on("click", ".deleteBtn", function() {
                var deleteId = $(this).attr('deleteId');
                var url = "<?php echo URL::route('reward.index'); ?>";
                $(".deleteForm").attr("action", url+'/'+deleteId);
            });
        });
    </script>
@stop
