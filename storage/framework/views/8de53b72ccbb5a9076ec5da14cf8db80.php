<?php $__env->startSection('title', 'Detalhes do Agendamento'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('appointments.index')); ?>">Agendamentos</a></li>
<li class="breadcrumb-item active">Detalhes</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Agendamento</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('appointments.edit', $appointment->id)); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px">ID</th>
                <td><?php echo e($appointment->id); ?></td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td><?php echo e($appointment->client ? $appointment->client->name : 'Cliente Removido'); ?></td>
            </tr>
            <tr>
                <th>Barbeiro</th>
                <td><?php echo e($appointment->barber && $appointment->barber->user ? $appointment->barber->user->name : 'Barbeiro Removido'); ?></td>
            </tr>
            <tr>
                <th>Serviço</th>
                <td><?php echo e($appointment->service ? $appointment->service->name . ' - R$ ' . number_format($appointment->service->price, 2, ',', '.') : 'Serviço Removido'); ?></td>
            </tr>
            <tr>
                <th>Data</th>
                <td><?php echo e($appointment->start_time->format('d/m/Y')); ?></td>
            </tr>
            <tr>
                <th>Horário</th>
                <td><?php echo e($appointment->start_time->format('H:i')); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <?php if($appointment->status == 'scheduled'): ?>
                        <span class="badge badge-primary">Agendado</span>
                    <?php elseif($appointment->status == 'confirmed'): ?>
                        <span class="badge badge-success">Confirmado</span>
                    <?php elseif($appointment->status == 'completed'): ?>
                        <span class="badge badge-info">Concluído</span>
                    <?php elseif($appointment->status == 'cancelled'): ?>
                        <span class="badge badge-danger">Cancelado</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Data de Criação</th>
                <td><?php echo e($appointment->created_at->format('d/m/Y H:i:s')); ?></td>
            </tr>
            <tr>
                <th>Última Atualização</th>
                <td><?php echo e($appointment->updated_at->format('d/m/Y H:i:s')); ?></td>
            </tr>
        </table>

        <?php if($appointment->notes): ?>
            <div class="mt-4">
                <h5>Observações</h5>
                <p class="text-muted"><?php echo e($appointment->notes); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-footer">
        <form action="<?php echo e(route('appointments.destroy', $appointment->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Elbarber_V4.0\resources\views/appointments/show.blade.php ENDPATH**/ ?>