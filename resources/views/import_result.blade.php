@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Extra Pages</a></li>
                        <li class="breadcrumb-item active">Starter</li>
                    </ol>
                </div>
                <h4 class="page-title">Starter</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Hasil Import</h4>
                    <p class="sub-header">
                        Most common form control, text-based input fields. Includes support for all HTML5
                        types: <code>text</code>, <code>password</code>, <code>datetime</code>,
                        <code>datetime-local</code>, <code>date</code>, <code>month</code>,
                        <code>time</code>, <code>week</code>, <code>number</code>, <code>email</code>,
                        <code>url</code>, <code>search</code>, <code>tel</code>, and <code>color</code>.
                    </p>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>PO No</th>
                                    <th>Order Date</th>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($rows))
                                    
                                @foreach ($rows as $row)
                                <tr>
                                    <th scope="row">{{ $row['vendor'] }}</th>
                                    <td>{{ $row['po_no'] }}</td>
                                    <td>{{ Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['order_date'])); }}</td>
                                    <td>{{ $row['item'] }}</td>
                                    <td>{{ $row['description'] }}</td>
                                    <td>{{ $row['qty'] }}</td>
                                </tr>                                    
                                @endforeach    
                                <tr>
                                    <td colspan="6">{{ $vendor[0] }}</td>
                                </tr>  
                                <tr>
                                    <td colspan="6">{{ $po_no[0] }}</td>
                                </tr>    
                                <tr>
                                    <td colspan="6">{{ Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($order_date[0])); }}</td>
                                </tr>                           
                                @else
                                <tr>
                                    <td colspan="6">no rows</td>
                                </tr>    
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection