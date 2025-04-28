<?php $__env->startSection('title', 'Produtos'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.product-thumbnail-container {
    position: relative;
    display: inline-block;
}

.product-thumbnail {
    width: 35px;
    height: 35px;
    object-fit: cover;
    border-radius: 4px;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item active">Produtos</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Produtos</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Produto
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th style="width: 50px">Foto</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th style="width: 120px">Preço</th>
                        <th style="width: 100px">Estoque</th>
                        <th style="width: 100px">Status</th>
                        <th style="width: 160px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($product->id); ?></td>
                            <td class="text-center">
                                <div class="product-thumbnail-container">
                                    <?php if($product->photo): ?>
                                        <img src="<?php echo e(Storage::url($product->photo)); ?>" 
                                             alt="Foto do Produto" 
                                             class="product-thumbnail">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('img/no-image.png')); ?>" 
                                             alt="Sem Foto" 
                                             class="product-thumbnail">
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><?php echo e($product->name); ?></td>
                            <td><?php echo e(Str::limit($product->description, 50)); ?></td>
                            <td>R$ <?php echo e(number_format($product->price, 2, ',', '.')); ?></td>
                            <td><?php echo e($product->stock); ?></td>
                            <td>
                                <?php if($product->is_active): ?>
                                    <span class="badge badge-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-info btn-sm" title="Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">Nenhum produto encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($products->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Elbarber_V4.0\resources\views/products/index.blade.php ENDPATH**/ ?>