@extends('layouts.master')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('css')
    <!-- DataTables CSS -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Carousel CSS -->
    <link href="{{ asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">

@endsection

@section('title', ' قائمة المنتجات')
@section('content')
    <!-- row -->
    <div class="row">

        <div class="col-xl-12">

            <div class="card">

                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                                data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
                        </div>
                        <div class="col">
                            @if (session('Add'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session('Add') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ session('error') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <strong>{{ $error }}</strong><br>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif



                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1" data-page-length="50">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">اسم المنتج</th>
                                    <th class="wd-20p border-bottom-0">اسم القسم</th>
                                    <th class="wd-20p border-bottom-0">ملاحظات</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->section->section_name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>
                                            <div class="btn-icon-list">
                                                <!-- Edit Button -->
                                                <a class="modal-effect btn btn-primary btn-icon rounded-circle shadow-sm mx-1"
                                                    data-effect="effect-scale" data-toggle="modal" data-target="#modaldemo1"
                                                    data-id="{{ $product->id }}"
                                                    data-section_id="{{ $product->section->id }}" 
                                                    data-product_name="{{ $product->product_name }}"
                                                    data-description="{{ $product->description }}" title="تعديل">
                                                    <i class="typcn typcn-edit text-white"></i>
                                                </a>



                                                <!-- Delete Button -->
                                                <a class="modal-effect btn btn-danger btn-icon rounded-circle shadow-sm mx-1"
                                                    data-effect="effect-scale" data-toggle="modal"
                                                    data-target="#deleteModal" data-id="{{ $product->id }}"
                                                    data-product_name="{{ $product->product_name }}" title="حذف">
                                                    <i class="typcn typcn-trash text-white"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
        <!-- Modal effects -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="product_name"> اسم المنتج</label>
                                <input class="form-control" type="text" id="product_name" name="product_name">
                            </div>

                            <div class="form-group">
                                <label for="section_id">اسم القسم</label>
                                <select class="form-control" name="section_id" id="section_id">
                                    <option selected disabled value="">اختر القسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description"> ملاحظات</label>
                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                            </div>

                            <div class="modal-footer">
                                <button class="btn ripple btn-primary" type="submit">اضافة</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">اغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal effects-->
        <!-- Edit Modal -->
        <div class="modal" id="modaldemo1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل منتج</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.update', '') }}" method="POST" id="editForm">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="edit_product_name">اسم المنتج</label>
                                <input class="form-control" type="text" id="edit_product_name" name="product_name">
                            </div>
                            <div class="form-group">
                                <label for="edit_section_name">اسم القسم</label>
                                <select class="form-control" name="section_id" id="edit_section_name">
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">
                                            {{ $section->section_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="edit_description">ملاحظات</label>
                                <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-primary" type="submit">تحديث</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">اغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">تأكيد الحذف</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('products.destroy', '') }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body text-center">
                            <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                            <h4>هل أنت متأكد من حذف المنتج؟</h4>
                            <p class="product-name-display mb-0 text-muted"></p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-danger px-4">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>



    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->


@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Internal Modal js for Edit and Delete actions -->
    <script>
        $('#modaldemo1').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var productName = button.data('product_name');
            var sectionId = button.data('section_id');
            var description = button.data('description');

            var modal = $(this);
            modal.find('#id').val(id);
            modal.find('#edit_product_name').val(productName);
            modal.find('#edit_section_name').val(sectionId);
            modal.find('#edit_description').val(description);

            // Update the action attribute in editForm
            modal.find('#editForm').attr('action', '{{ route('products.update', '') }}/' + id);
        });


        // Delete Modal
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var productName = button.data('product_name');

            var modal = $(this);
            modal.find('.product-name-display').text(productName);

            // Update the action attribute in deleteForm
            modal.find('#deleteForm').attr('action', '{{ route('products.destroy', '') }}/' + id);
        });
    </script>
@endsection
