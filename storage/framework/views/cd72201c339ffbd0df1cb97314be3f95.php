<?php $__env->startSection('title', 'Detalhes do Produto'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Produtos</a></li>
<li class="breadcrumb-item active">Detalhes</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Produto</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px">ID</th>
                <td><?php echo e($product->id); ?></td>
            </tr>
            <tr>
                <th>Nome</th>
                <td><?php echo e($product->name); ?></td>
            </tr>
            <tr>
                <th>Preço</th>
                <td>R$ <?php echo e(number_format($product->price, 2, ',', '.')); ?></td>
            </tr>
            <tr>
                <th>Estoque</th>
                <td><?php echo e($product->stock); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <?php if($product->is_active): ?>
                        <span class="badge badge-success">Ativo</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Inativo</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Data de Criação</th>
                <td><?php echo e($product->created_at->format('d/m/Y H:i:s')); ?></td>
            </tr>
            <tr>
                <th>Última Atualização</th>
                <td><?php echo e($product->updated_at->format('d/m/Y H:i:s')); ?></td>
            </tr>
        </table>

        <?php if($product->description): ?>
            <div class="mt-4">
                <h5>Descrição</h5>
                <p class="text-muted"><?php echo e($product->description); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-footer">
        <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Elbarber_V4.0\resources\views/products/show.blade.php ENDPATH**/ ?>