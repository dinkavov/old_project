
$factory->define(<?php echo e($reflection->getName()); ?>::class, function (Faker\Generator $faker) {
    return [
<?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        '<?php echo e($name); ?>' => <?php if($property['faker']): ?><?php echo $property['type']; ?><?php else: ?>'<?php echo e($property['type']); ?>'<?php endif; ?>,
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ];
});

