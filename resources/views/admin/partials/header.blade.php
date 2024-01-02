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
                    {{-- @elseif ($title === 'All Sukarelawans')
                    <form id="deleteAllForm" action="/delete/all-sukarelawans" method="post"
                        @if ($sukarelawans->count() === 0) style="display: none;" @endif>
                        @method('delete')
                        @csrf
                    </form>

                    <button class="btn btn-danger" onclick="showAllDeletionConfirmation()"
                        @if ($sukarelawans->count() === 0) style="display: none;" @endif>
                        <i class="fas fa-trash"></i>
                        Hapus semua
                    </button> --}}
                @elseif ($title === 'Waiting For Verification Fasilitators')
                    <form id="verifyAllForm" action="/verify/all-fasilitators" method="post"
                        @if ($fasilitators->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i>
                            Verifikasi semua
                        </button>
                    </form>

                    <form id="rejectAllForm" action="/reject/all-fasilitators" method="post"
                        @if ($fasilitators->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <input type="hidden" name="allReasonForRejection" id="allReasonForRejection">
                    </form>

                    <div class="mx-1" @if ($fasilitators->count() === 0) style="display: none;" @endif></div>

                    <button class="btn btn-danger" onclick="showAllReasonForRejectionInput()"
                        @if ($fasilitators->count() === 0) style="display: none;" @endif>
                        <i class="fas fa-times"></i>
                        Tolak semua
                    </button>
                @elseif ($title === 'Verified Fasilitators')
                    <form id="unverifyAllForm" action="/unverify/all-fasilitators" method="post"
                        @if ($fasilitators->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                            Kembalikan semua
                        </button>
                    </form>
                @elseif ($title === 'Rejected Fasilitators')
                    <form id="unrejectAllForm" action="/unreject/all-fasilitators" method="post"
                        @if ($fasilitators->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                            Kembalikan semua
                        </button>
                    </form>
                    {{-- @elseif ($title === 'All Fasilitators')
                    <form id="deleteAllForm" action="/delete/all-fasilitators" method="post"
                        @if ($fasilitators->count() === 0) style="display: none;" @endif>
                        @method('delete')
                        @csrf
                    </form>

                    <button class="btn btn-danger" onclick="showAllDeletionConfirmation()"
                        @if ($fasilitators->count() === 0) style="display: none;" @endif>
                        <i class="fas fa-trash"></i>
                        Hapus semua
                    </button> --}}
                @elseif ($title === 'Waiting For Verification Activities')
                    <form id="verifyAllForm" action="/verify/all-activities" method="post"
                        @if ($activities->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <input type="hidden" name="allExperiencePointGiven" id="allExperiencePointGiven">
                    </form>

                    <button class="btn btn-success" onclick="showAllExperiencePointGivenInput()"
                        @if ($activities->count() === 0) style="display: none;" @endif>
                        <i class="fas fa-check"></i>
                        Verifikasi semua
                    </button>

                    <form id="rejectAllForm" action="/reject/all-activities" method="post"
                        @if ($activities->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <input type="hidden" name="allReasonForRejection" id="allReasonForRejection">
                    </form>

                    <div class="mx-1" @if ($activities->count() === 0) style="display: none;" @endif></div>

                    <button class="btn btn-danger" onclick="showAllReasonForRejectionInput()"
                        @if ($activities->count() === 0) style="display: none;" @endif>
                        <i class="fas fa-times"></i>
                        Tolak semua
                    </button>
                @elseif ($title === 'Verified Activities')
                    <form id="unverifyAllForm" action="/unverify/all-activities" method="post"
                        @if ($activities->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                            Kembalikan semua
                        </button>
                    </form>
                @elseif ($title === 'Rejected Activities')
                    <form id="unrejectAllForm" action="/unreject/all-activities" method="post"
                        @if ($activities->count() === 0) style="display: none;" @endif>
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                            Kembalikan semua
                        </button>
                    </form>
                    {{-- @elseif ($title === 'All Activities')
                    <form id="deleteAllForm" action="/delete/all-activities" method="post"
                        @if ($activities->count() === 0) style="display: none;" @endif>
                        @method('delete')
                        @csrf
                    </form>

                    <button class="btn btn-danger" onclick="showAllDeletionConfirmation()"
                        @if ($activities->count() === 0) style="display: none;" @endif>
                        <i class="fas fa-trash"></i>
                        Hapus semua
                    </button> --}}
                @elseif ($title === 'Benefits')
                    <a class="btn btn-success" href="/admin/benefits/create">
                        <i class="fas fa-plus"></i>
                        Buat baru
                    </a>

                    <form id="deleteAllForm" action="/admin/benefits" method="post"
                        @if ($benefits->count() === 0) style="display: none;" @endif>
                        @method('delete')
                        @csrf
                    </form>

                    <div class="mx-1" @if ($benefits->count() === 0) style="display: none;" @endif></div>

                    <button class="btn btn-danger" onclick="showAllDeletionConfirmation()"
                        @if ($benefits->count() === 0) style="display: none;" @endif>
                        <i class="fas fa-trash"></i>
                        Hapus semua
                    </button>
                @endif
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
