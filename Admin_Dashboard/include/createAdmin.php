<style>
    .container_ {
    width: 100%;
    max-width: 500px;
    margin: 50px auto;
    }

    .card_ {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .sp{
         padding: 20px;
    }
    .btn-primary{
        width: 95%;
    }
</style>

<div class="container_ mt-5">
    <div class="card_">
        <h4 class="mb-4">Create Admin</h4>
        <form action="" method="post" class="sp">
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
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="createAdmin">Submit</button>
            </div>
        </form>
    </div>
</div>