```html
<!DOCTYPE html>
<html>
<head>
    <title>Retainers List</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        body{
            background:#111111;
            min-height:100vh;
            padding:40px;
        }

        .container{
            max-width:1100px;
            margin:auto;
        }

        .card{
            background:#f5f0e6;
            padding:30px;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,.4);
        }

        h2{
            color:#111111;
            margin-bottom:20px;
            text-align:center;
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
        }

        .btn{
            text-decoration:none;
            padding:10px 18px;
            border-radius:10px;
            color:white;
            font-weight:600;
        }

        .btn-add{
            background:#111111;
        }

        .btn-view{
            background:#8b7355;
        }

        .btn-edit{
            background:#444444;
        }

        .btn-delete{
            background:#8b0000;
            border:none;
            cursor:pointer;
        }

        .success{
            background:#d4edda;
            color:#155724;
            padding:12px;
            border-radius:10px;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:10px;
            overflow:hidden;
        }

        th{
            background:#111111;
            color:white;
            padding:15px;
            text-align:left;
        }

        td{
            padding:15px;
            border-bottom:1px solid #ddd;
        }

        tr:hover{
            background:#f8f8f8;
        }

        .actions{
            display:flex;
            gap:8px;
            align-items:center;
        }

        form{
            display:inline;
        }
        .btn{
    text-decoration:none;
    padding:10px 18px;
    border-radius:10px;
    color:white;
    font-weight:600;
}

.btn-delete{
    background:#8B0000;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
    transition:0.3s;
}

.btn-delete:hover{
    background:#5c0000;
}
.btn{
    text-decoration:none;
    padding:10px 18px;
    border-radius:10px;
    color:white;
    font-weight:600;
    display:inline-block;
    transition:0.3s;
}

.btn-view{
    background:#8b7355;
}

.btn-view:hover{
    background:#6f5b43;
}

.btn-edit{
    background:#111111;
}

.btn-edit:hover{
    background:#333333;
}

</style>
</head>
<body>

<div class="container">

    <div class="card">

        <h2>Retainers List</h2>

        <div class="top-bar">
            <div></div>

            <a href="/retainers/create" class="btn btn-add">
                + Add New Retainer
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Actions</th>
            </tr>

            <?php $__currentLoopData = $retainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($retainer->id); ?></td>
                <td><?php echo e($retainer->name); ?></td>
                <td><?php echo e($retainer->mobile); ?></td>

                <td>
                    <div class="actions">

                        <a href="/retainers/<?php echo e($retainer->id); ?>"
                           class="btn btn-view">
                            View
                        </a>

                        <a href="/retainers/<?php echo e($retainer->id); ?>/edit"
                           class="btn btn-edit">
                            Edit
                        </a>

                        <form action="/retainers/<?php echo e($retainer->id); ?>"
                              method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="submit"
                                    class="btn btn-delete"
                                    onclick="return confirm('Delete this retainer?')">
                                Delete
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </table>

    </div>

</div>

</body>
</html>
```
<?php /**PATH C:\xampp\htdocs\axvero\crm\resources\views/retainers/index.blade.php ENDPATH**/ ?>