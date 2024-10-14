<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label for="profile_image">Upload Profile Picture</label>
        <input type="file" name="profile_image" id="profile_image" accept="image/*">
    </div>

    <button type="submit">Update Profile</button>
</form>
