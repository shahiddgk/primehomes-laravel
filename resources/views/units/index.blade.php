@extends('layouts.app')


@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Units Listing</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Units</a></li>
              <li class="breadcrumb-item active">Listing</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <a style="float:right;" class="btn btn-primary" href="{{URL('unitimportview')}}">Import Units</a><a style="float:right;" class="btn btn-secondary" href="{{URL('exportunits')}}">Export Units</a>

                   
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Building</th>
                            <th>Unit No:</th>
                            <th>Owner</th>
                            <th>Unit Type</th>
                            <th>Floor Area</th>
                            <th>Parking</th>
                            <th>Slot No:</th>
                            <th>Area</th>
                            <th>Unit Fully Paid</th>
                            <th>Parking Location</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i=0; @endphp
                        @forelse ($units as $unit)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $unit->building_name }} (phase {{$unit->phase}})</td>
                            <td>{{ $unit->unit_no }}</td>
                            <td>{{ $unit->firstname }} {{ $unit->lastname }}</td>
                            <td>{{ $unit->unit_type }}</td>
                            <td>{{ $unit->floor_area }}</td>
                            <td>{{ $unit->parking }}</td>
                            <td>{{ $unit->slot_no }}</td>
                            <td>{{ $unit->parking_area }}</td>
                            <td>{{ $unit->unit_paid }}</td>
                            <td>{{ $unit->parking_location }}</td>
                            <td><form action="{{ route('units.destroy',$unit->id) }}" method="POST">
                                <a class="btn btn-primary" href="{{ route('units.edit',$unit->id) }}">Edit</a>

                                    @csrf
                                    @method('DELETE')
                                
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="13" align="center">No Data</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                
                </div>
                
            </div>
        </div>
    </section>

@endsection