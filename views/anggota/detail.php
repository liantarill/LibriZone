<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Detail Anggota</h2>
            <button onclick="closeModal('detailModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
            </div>
            <h3 class="text-lg font-semibold text-gray-800" id="nama"></h3>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="font-medium text-gray-600">ID:</span>
                <span id="id" class="text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Alamat:</span>
                <span id="alamat" class="text-gray-800 text-right"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-600">No. HP:</span>
                <span id="no_hp" class="text-gray-800"></span>
            </div>
        </div>
    </div>
</div>