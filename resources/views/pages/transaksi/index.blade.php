@extends('layouts.master')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Pengurusan Transaksi</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Senarai Transaksi</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase">Senarai Transaksi</h6>
<hr />
<div class="card">
    <div class="card-body">
        <div class="d-lg-flex align-items-center mb-4 gap-3">
            <div class="position-relative">
                <form action="#" method="GET" id="searchForm"
                    class="d-lg-flex align-items-center gap-3">
                    <div class="input-group">
                        <input type="text" class="form-control rounded" placeholder="Carian..." name="search"
                            value="{{ request('search') }}" id="searchInput">

                        <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                        <a href="{{ route('transaksi') }}" class="btn btn-primary ms-1 rounded" id="searchButton">
                            <i class="bx bx-search"></i>
                        </a>
                        <a href="{{ route('transaksi') }}" class="btn btn-secondary ms-1 rounded" id="resetButton">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
            <div class="ms-auto">
                <a href="#" target="_blank"
                    class="btn btn-info mb-0">Muat Turun PDF</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tarikh Agihan</th>
                        <th>ID Pelajar</th>
                        <th>Nama</th>
                        <th>Kampus</th>
                        <th>Nilai Kupon (RM)</th>
                        <th>Tarikh Luput</th>
                        <th>Premis</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>17-12-2024</td>
                        <td>2024111111</td>
                        <td>Samarahan</td>
                        <td>John Doe</td>
                        <td>10.00</td>
                        <td>01-12-2025</td>
                        <td>-</td>
                        <td>Belum Diguna</td>
                        <td>
                            <a href="{{ route('transaksi.claim') }}" class="btn btn-success btn-sm"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Claim Kupon">
                                <i class="bx bx-gift"></i> Claim Kupon
                            </a>
                            <a href="{{ route('transaksi.show')}}" class="btn btn-primary btn-sm"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Papar">
                                <i class="bx bx-show"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>17-12-2024</td>
                        <td>2024222222</td>
                        <td>Samarahan 2</td>
                        <td>Ali Bin Abu</td>
                        <td>10.00</td>
                        <td>01-12-2025</td>
                        <td>Unihaus</td>
                        <td>Telah Dituntut</td>
                        <td>
                            <a href="{{ route('transaksi.show')}}" class="btn btn-primary btn-sm"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Papar">
                                <i class="bx bx-show"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <span class="mr-2 mx-1">Jumlah rekod per halaman</span>
                <form action="#" method="GET" id="perPageForm"
                    class="d-flex align-items-center">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="perPage" id="perPage" class="form-select form-select-sm"
                        onchange="document.getElementById('perPageForm').submit()">
                        <option value="10" {{ Request::get('perPage') == '10' ? 'selected' : '' }}>10</option>
                        <option value="20" {{ Request::get('perPage') == '20' ? 'selected' : '' }}>20</option>
                        <option value="30" {{ Request::get('perPage') == '30' ? 'selected' : '' }}>30</option>
                    </select>
                </form>
            </div>

            <div class="d-flex justify-content-end align-items-center">
                <span class="mx-2 mt-2 small text-muted">
                    Menunjukkan 1 hingga 2 daripada
                    3 rekod
                </span>
                <div class="pagination-wrapper">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Pengesahan Padam Rekod</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Adakah anda pasti ingin memadam rekod 1?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <form class="d-inline" method="POST" action="">
                    <a href="{{ route('transaksi') }}" class="btn btn-danger">Padam</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit the form on input change
        document.getElementById('searchInput').addEventListener('input', function() {
            document.getElementById('searchForm').submit();
        });

        // Reset form
        document.getElementById('resetButton').addEventListener('click', function() {
            // Redirect to the base route to clear query parameters
            window.location.href = "{{ route('transaksi') }}";
        });
    });
</script>
<!--end page wrapper -->
@endsection