<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 d-flex align-items-center">
            <div class="col-8 d-flex justify-content-start">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
            <div class="col-4 d-flex justify-content-end">
                @if ($title === 'Waiting For Verification Sukarelawans')
                    <form id="verifyAllForm" action="/verify/all-sukarelawans" method="post"
                        @if ($sukarelawans->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i>
                            Verifikasi semua
                        </button>
                    </form>

                    <form id="rejectAllForm" action="/reject/all-sukarelawans" method="post"
                        @if ($sukarelawans->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <input type="hidden" name="allReasonForRejection" id="allReasonForRejection">
                    </form>

                    <div class="mx-1" @if ($sukarelawans->count() === 0) style="display: none;" @endif></div>

                    <button class="btn btn-danger" onclick="showAllReasonForRejectionInput()"
                        @if ($sukarelawans->count() === 0) style="display: none;" @endif>
                        <i class="fas fa-times"></i>
                        Tolak semua
                    </button>
                @elseif ($title === 'Verified Sukarelawans')
                    <form id="unverifyAllForm" action="/unverify/all-sukarelawans" method="post"
                        @if ($sukarelawans->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                            Kembalikan semua
                        </button>
                    </form>
                @elseif ($title === 'Rejected Sukarelawans')
                    <form id="unrejectAllForm" action="/unreject/all-sukarelawans" method="post"
                        @if ($sukarelawans->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                            Kembalikan semua
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
