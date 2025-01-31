<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4><?php echo lang('index_heading'); ?></h4>
                <div class="card-header-action">
                    <a href="<?php echo site_url('auth/create_user'); ?>" class="btn btn-sm btn-primary">
                        <?php echo lang('index_create_user_link'); ?>
                    </a>
                    <a href="<?php echo site_url('auth/create_group'); ?>" class="btn btn-sm btn-info">
                        <?php echo lang('index_create_group_link'); ?>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="infoMessage"><?php echo $message; ?></div>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th><?php echo lang('index_fname_th'); ?></th>
                            <th><?php echo lang('index_lname_th'); ?></th>
                            <th><?php echo lang('index_email_th'); ?></th>
                            <th><?php echo lang('index_groups_th'); ?></th>
                            <th><?php echo lang('index_status_th'); ?></th>
                            <th><?php echo lang('index_action_th'); ?></th>
                        </tr>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php foreach ($user->groups as $group) : ?>
                                        <?php echo anchor("auth/edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')); ?><br />
                                    <?php endforeach ?>
                                </td>
                                <td><?php echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); ?></td>
                                <td>
                                    <a href="<?php echo site_url('auth/edit_user/') . $user->id; ?>" class="btn btn-sm btn-icon btn-primary">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>