<div class="container mt-5">
    <div class="card p-4 shadow-sm">
        <h4 class="mb-4">Create Admin</h4>
        <form>
            <div class="mb-3">
                <label for="admin_role" class="form-label">Admin Role</label>
                <select class="form-select" name="admin_role" id="admin_role">
                    <option value="admin">Admin</option>
                    <option value="sup_admin">Super Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="admin_id" class="form-label">Admin ID</label>
                <input type="text" class="form-control" id="admin_id" name="admin_id" placeholder="Admin Identity" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="c-password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="c-password" name="c-password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>