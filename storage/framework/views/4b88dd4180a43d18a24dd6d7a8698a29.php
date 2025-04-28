<?php $__env->startSection('title', 'Detalhes do Serviço'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('services.index')); ?>">Serviços</a></li>
<li class="breadcrumb-item active">Detalhes do Serviço</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Serviço</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('services.edit', $service)); ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="<?php echo e(route('services.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%">ID</th>
                        <td><?php echo e($service->id); ?></td>
                    </tr>
                    <tr>
                        <th>Nome</th>
                        <td><?php echo e($service->name); ?></td>
                    </tr>
                    <tr>
                        <th>Preço</th>
                        <td>R$ <?php echo e(number_format($service->price, 2, ',', '.')); ?></td>
                    </tr>
                    <tr>
                        <th>Duração</th>
                        <td><?php echo e($service->duration); ?> minutos</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if($service->is_active): ?>
                            <span class="badge badge-success">Ativo</span>
                            <?php else: ?>
                            <span class="badge badge-danger">Inativo</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Criado em</th>
                        <td><?php echo e($service->created_at->format('d/m/Y H:i:s')); ?></td>
                    </tr>
                    <tr>
                        <th>Atualizado em</th>
                        <td><?php echo e($service->updated_at->format('d/m/Y H:i:s')); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Descrição</h3>
                    </div>
                    <div class="card-body">
                        <?php if($service->description): ?>
                            <?php echo e($service->description); ?>

                        <?php else: ?>
                            <p class="text-muted">Nenhuma descrição disponível.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <form action="<?php echo e(route('services.destroy', $service)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Elbarber_V4.0\resources\views/services/show.blade.php ENDPATH**/ ?>