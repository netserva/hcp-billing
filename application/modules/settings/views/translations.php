<?php declare(strict_types=1);
if (!isset($language)) { ?>
 
          <p>
            <div class="add-translation">
                    <select id="add-language" class="select2-option" name="language">
                    <?php foreach ($available as $loc) { ?>
                    <option value="<?php echo str_replace(' ', '_', $loc->language); ?>"><?php echo ucwords($loc->language); ?></option>
                    <?php } ?>
                    </select>
                <button id="add-translation" class="btn btn-sm btn-<?php echo config_item('theme_color'); ?>"><?php echo lang('add_language'); ?></button>
            </div>
            </p> 
       
            <div class="table-responsive">
              <table id="table-translations" class="table table-striped b-t b-light AppendDataTables">
                <thead>
                        <tr>
                        <th class="no-sort"><?php echo lang('icon'); ?></th>
                        <th><?php echo lang('language'); ?></th>
                        <th class="col-options no-sort"><?php echo lang('action'); ?></th>
                        <th><?php echo lang('progress'); ?></th>
                        <th><?php echo lang('remaining'); ?></th>
                        <th><?php echo lang('total'); ?></th>
                        </tr>
                </thead>
                <tbody>
                    <?php foreach ($languages as $l) {
    $st = $translation_stats;
    $total = $st[$l->name]['total'];
    $translated = $st[$l->name]['translated'];
    $pc = round(intval(($translated / $total) * 1000) / 10);
    $remaining = $total - $translated;
    if ('english' != $l->name) {
        ?>
                    <tr>
                        <td class=""><img src="<?php echo base_url('resource/images/flags/'.$l->icon); ?>.gif" /></td>
                        <td class=""><?php echo ucwords(str_replace('_', ' ', $l->name)); ?></td>
                        <td class="">
                          <a data-rel="tooltip" data-original-title="<?php echo (1 == $l->active ? lang('deactivate') : lang('activate')); ?>" class="active-translation btn btn-sm btn-<?php echo (0 == $l->active ? 'danger' : 'success'); ?>" href="#" data-href="<?php echo base_url(); ?>settings/translations/active/<?php echo $l->name; ?>/?settings=translations"><i class="fa fa-power-off"></i></a>
                          <a data-rel="tooltip" data-original-title="<?php echo lang('edit'); ?>" class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>settings/translations/view/<?php echo $l->name; ?>/?settings=translations"><i class="fa fa-edit"></i> <?php echo lang('edit_translation'); ?></a>
                          <a data-rel="tooltip" data-original-title="<?php echo lang('backup'); ?>" class="backup-translation btn btn-sm btn-default" href="#" data-href="<?php echo base_url(); ?>settings/translations/backup/<?php echo $l->name; ?>/?settings=translations"><i class="fa fa-download"></i> <?php echo lang('backup'); ?></a>
                          <a data-rel="tooltip" data-original-title="<?php echo lang('restore'); ?>" class="restore-translation btn btn-sm btn-default" href="#" data-href="<?php echo base_url(); ?>settings/translations/restore/<?php echo $l->name; ?>/?settings=translations"><i class="fa fa-upload"></i> <?php echo lang('restore'); ?></a>
                        </td>
                        <td>
                            <div class="progress progress-sm">
                            <?php $bar = 'danger';
        if ($pc > 20) {
            $bar = 'warning';
        }
        if ($pc > 50) {
            $bar = 'info';
        }
        if ($pc > 80) {
            $bar = 'success';
        } ?>
                            <div class="progress-bar progress-bar-<?php echo $bar; ?>" role="progressbar" aria-valuenow="<?php echo $pc; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pc; ?>%;">
                            <?php echo $pc; ?>%
                            </div>
                            </div>                        
                        </td>
                        <td class=""><?php echo $remaining; ?></td>
                        <td class=""><?php echo $total; ?></td>
                        
                    </tr>
                    <?php
    }
} ?>
                </tbody>
              </table>
          </div>
    
    
    <?php } elseif (!isset($language_file)) { ?> 


 
<header class="box-header font-bold"><i class="fa fa-cogs"></i><?php echo lang('translations'); ?> - <?php echo ucwords($language); ?></header>
            <div class="table-responsive">
              <table id="table-translations-files" class="table table-striped b-t b-light AppendDataTables">
                <thead>
                        <tr>
                        <th class="col-xs-2 no-sort"><?php echo lang('type'); ?></th>
                        <th class="col-xs-3"><?php echo lang('file'); ?></th>
                        <th class="col-xs-4"><?php echo lang('translated'); ?></th>
                        <th class="col-xs-1"><?php echo lang('done'); ?></th>
                        <th class="col-xs-1"><?php echo lang('total'); ?></th>
                        <th class="col-options no-sort col-xs-1"><?php echo lang('action'); ?></th>
                        </tr>
                </thead>
                <tbody>
                    <?php foreach ($language_files as $file => $altpath) {
    $shortfile = str_replace('_lang.php', '', $file);
    $st = $translation_stats[$language]['files'][$shortfile];
    $fn = ucwords(str_replace('_', ' ', $shortfile));
    if ('hd' == $shortfile) {
        $fn = 'Main Application';
    }
    if ('tank_auth' == $shortfile) {
        $fn = 'Authenication';
    }
    $total = $st['total'];
    $translated = $st['translated'];
    $pc = intval(($translated / $total) * 1000) / 10; ?>
                    <tr>
                        <td class=""><?php echo ('./system/' == $altpath ? 'System' : 'Application'); ?></td>
                        <td class=""><a href="<?php echo base_url(); ?>settings/translations/edit/<?php echo $language; ?>/<?php echo $shortfile; ?>/?settings=translations"><?php echo $fn; ?></a></td>
                        <td>
                            <div class="progress progress-sm">
                            <?php $bar = 'danger';
    if ($pc > 20) {
        $bar = 'warning';
    }
    if ($pc > 50) {
        $bar = 'info';
    }
    if ($pc > 80) {
        $bar = 'success';
    } ?>
                            <div class="progress-bar progress-bar-<?php echo $bar; ?>" role="progressbar" aria-valuenow="<?php echo $pc; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pc; ?>%;">
                            <?php echo $pc; ?>%
                            </div>
                            </div>                        
                        </td>
                        <td class=""><?php echo $translated; ?></td>
                        <td class=""><?php echo $total; ?></td>
                        <td class="">
                          <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>settings/translations/edit/<?php echo $language; ?>/<?php echo $shortfile; ?>/?settings=translations"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                        </td>
                    </tr>
                    <?php
} ?>
                </tbody>
              </table>
            </div>
 

    <?php } else { ?>
    
    <?php $attributes = ['class' => 'bs-example form-horizontal', 'id' => 'form-strings'];
    echo form_open_multipart('settings/translations/save/'.$language.'/'.$language_file.'/?settings=translations', $attributes); ?> 
    <input type="hidden" name="_language" value="<?php echo $language; ?>">
    <input type="hidden" name="_file" value="<?php echo $language_file; ?>">
    
    <section class="box box-default">
    <header class="box-header font-bold"><i class="fa fa-cogs"></i>
    <?php $fn = ucwords(str_replace('_', ' ', $language_file));
    if ('hd' == $language_file) {
        $fn = 'Main Application';
    }
    if ('tank_auth' == $language_file) {
        $fn = 'Authenication';
    }

    $total = count($english);
    $translated = 0;
    if ('english' == $language) {
        $percent = 100;
    } else {
        foreach ($english as $key => $value) {
            if (isset($translation[$key]) && $translation[$key] != $value) {
                ++$translated;
            }
        }
        $percent = intval(($translated / $total) * 100);
    }
    ?>
    <?php echo lang('translations'); ?> | <a href="<?php echo base_url(); ?>settings/translations/view/<?php echo $language; ?>/?settings=translations"><?php echo ucwords(str_replace('_', ' ', $language)); ?></a> | <?php echo $fn; ?> | <?php echo $percent; ?>% <?php echo mb_strtolower(lang('done')); ?>
    <button type="submit" id="save-translation" class="btn btn-xs btn-primary pull-right"><?php echo lang('save_translation'); ?></button>
    </header>
        <div class="table-responsive">
          <table id="table-strings" class="table table-striped b-t b-light AppendDataTables">
            <thead>
              <tr>
                <th class="col-xs-5">English</th>
                <th class="col-xs-7"><?php echo ucwords(str_replace('_', ' ', $language)); ?></th>
              </tr>
            </thead>
            <tbody>
                <?php
                foreach ($english as $key => $value) { ?>
              <tr>
                <td><?php echo $value; ?></td>
                <td><input class="form-control" width="100%" type="text" value="<?php echo ($translation[$key] ?? $value); ?>" name="<?php echo $key; ?>" /></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

<!-- End details -->
 </section>
</form> 

<?php } ?>
