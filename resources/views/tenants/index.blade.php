@extends('layouts.app')


@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tenants Listing</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Tenants</a></li>
              <li class="breadcrumb-item active">Listing</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Alert!</h5>
        {{ $message }}
      </div>
    @endif
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <a class="btn btn-primary" style="float:right;" href="{{ URL('tenant_import_view') }}">Import Tenants</a><a style="float:right;" class="btn btn-secondary" href="{{ URL('exporttenant') }}">Export Tenants</a>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                    <table id="example1" class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Lastname</th>
                            <th>Middle Name</th>
                            <th>Landline</th>
                            <th>Primary Mobile</th>
                            <th>Secondary Mobile</th>
                            <th>Primary Email</th>
                            <th>Secondary Email</th>
                            <th>Alternate Email</th>
                            <th>Emergency Contact Person</th>
                            <th>Emergency Contact</th>
                            <th>Valid ID</th>
                            <th>Other Document</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          @php $i=0; @endphp
                        @forelse ($tenants as $tenant)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $tenant->firstname }}</td>
                            <td>{{ $tenant->lastname }}</td>
                            <td>{{ $tenant->middlename }}</td>
                            <td>{{ $tenant->landline }}</td>
                            <td>{{ $tenant->primary_mobile }}</td>
                            <td>{{ $tenant->secondary_mobile }}</td>
                            <td>{{ $tenant->primary_email }}</td>
                            <td>{{ $tenant->secondary_email }}</td>
                            <td>{{ $tenant->alternate_email }}</td>
                            <td>{{ $tenant->contact_person }}</td>
                            <td>{{ $tenant->contact_number }}</td>
                            <td>@if($tenant->valid_id)<a href="{{asset('ownersdocument/'.$tenant->valid_id)}}" download><i class="fas fa-file"></i> @endif</td>
                            <td>@if($tenant->other_document)<a href="{{asset('ownersdocument/'.$tenant->other_document)}}" download><i class="fas fa-file"></i> @endif</td>
                            <td><form action="{{ route('tenants.destroy',$tenant->id) }}" method="POST">
                                <a class="btn btn-primary" href="{{ route('tenants.edit',$tenant->id) }}">Edit</a>

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