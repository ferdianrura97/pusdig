@extends('layouts.master')
@section('content')
@if (\Auth::user()->role_id == 1)
<div class="row mt-2">
    <div class="col-md-12">
        <div class="box box-warning">
            <p>
                @if ($dt->is_verify == 0)
                <a href="{{url('book/verify', $dt->id)}}" id="" class="btn btn-sm btn-flat btn-success"><i
                        class="fa fa-check"></i> Verify
                </a>
                @else
                <button class="btn btn-danger" disabled><i class="fa fa-ban"></i> Verified</button>
                @endif
            </p>
            <hr>
            <div class="row">
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3>Detail Buku</h3>
                            <hr>
                            <small>Posted By <strong>{{ $dt->user->name }}</strong> at
                                {{ \Carbon\Carbon::parse($dt->created_at)->diffForHumans() }}
                            </small>
                        </div>
                        <div class="card-body">
                            <nav class="w-100">
                                <div class="nav nav-tabs" id="product-tab" role="tablist">
                                    <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments"
                                        role="tab" aria-controls="product-comments" aria-selected="false">Review
                                        ({{ $dt->comments()->count() }})</a>
                                </div>
                            </nav>
                            <div class="row" id="komen">
                                <div class="col-md-12">
                                    <div class="tab-content p-3 mr-auto" id="nav-tabContent">
                                        <div class="tab-pane fade" id="product-comments" role="tabpanel"
                                            aria-labelledby="product-comments-tab">
                                            <hr>
                                            <!-- Post -->
                                            @foreach ($dt->comments as $cm)
                                            <div class="post clearfix mt-4">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm"
                                                        src="https://cdn.iconscout.com/icon/free/png-512/avatar-372-456324.png"
                                                        alt="User Image">
                                                    @if ($cm->user->role_id == 1)
                                                    <span class="username">
                                                        <a href="#">{{ $cm->user->name }} <i class="fa fa-check-circle"
                                                                style="color: blue;"></i></a>
                                                    </span>
                                                    <span class="description">Admin - Sent at
                                                        {{ \Carbon\Carbon::parse($cm->created_at)->diffForHumans() }} </span>
                                                    @else
                                                    <span class="username">
                                                        <a href="#">{{ $cm->user->name }}</a>
                                                    </span>
                                                    <span class="description">Sent at
                                                        {{ \Carbon\Carbon::parse($cm->created_at)->diffForHumans() }} </span>
                                                    @endif
                                                </div>
                                                <!-- /.user-block -->
                                                <p>
                                                    {!! $cm->text !!}
                                                </p>
                                            </div>
                                            @endforeach
                                            <!-- /.post -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a target="_blank" class="btn btn-primary btn-lg btn-block mt-2" href="{{ url('book/read', $dt->slug) }}">
                                <i class="fas fa-book"></i> Baca Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <div class="card-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>Judul</th>
                                        <td>:</td>
                                        <td>{{ $dt->judul }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penulis</th>
                                        <td>:</td>
                                        <td>{{ $dt->penulis }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penerbit</th>
                                        <td>:</td>
                                        <td>{{ $dt->penerbit }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td>:</td>
                                        <td>{{ $dt->categories->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat</th>
                                        <td>:</td>
                                        <td>{{ date('d F Y', strtotime($dt->created_at)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <div class="card-body">
                            <p>Ringkasan :</p>
                            {!! $dt->ringkasan !!}
                        </div>
                    </div>

                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title"> Cover</h3>
                        </div>
                        <div class="card-body">
                            <img src="{{ url('cover', $dt->cover) }}" alt="" style="width: 100%">
                        </div>
                    </div>
                </div>

            </div>

            </form>
        </div>
    </div>
</div>
@else
@include('layouts.404')
@endif
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '.btn-file :file', function () {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function (event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
        });
    });

</script>
@endsection
