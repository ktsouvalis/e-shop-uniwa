<form action="{{ route('address.store') }}" method="POST">
    @csrf
    <div class="form-group mb-3">
        <label for="name" class="form-label">Ονοματεπώνυμο</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
    </div>
    <div class="form-group mb-3">
        <label for="address" class="form-label">Οδός και Αριθμός</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="123 Main St" required>
    </div>
    <div class="form-group mb-3">
        <label for="city" class="form-label">Πόλη</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="Athens" required>
    </div>
    <div class="form-group mb-3">
        <label for="zip" class="form-label">Τ.Κ.</label>
        <input type="text" class="form-control" id="zip" name="zip" placeholder="12345" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Add Address</button>
</form>
