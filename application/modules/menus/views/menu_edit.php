<h2>Edit Menu Item</h2>
<form method="post" action="<?php echo site_url('menus/save'); ?>">

    <div class="form-group">
        <label for="edit-menu-title">Title</label>
        <input required type="text" name="title" id="edit-menu-title" class="form-control" style="width: 100%"
               value="<?php echo htmlentities($row->title); ?>">
    </div>
    <div class="form-group">
        <label for="edit-menu-url">URL</label>
        <input <?php echo ($row->page > 0) ? 'readonly' : ''; ?> type="text" name="url" class="form-control" style="width: 100%" id="edit-menu-url" value="<?php echo $row->url; ?>">
    </div>
 
    <?php if (0 == $row->parent_id) { //only top level menu can be moved?>
        <div class="form-group">
            <label for="select_group_id">Group</label>
            <select name="group_id" id="select_group_id" class="form-control">
                <?php foreach ($menu_groups as $group) { ?>
                    <option value="<?php echo $group->id; ?>" <?php if ($group->id == $row->group_id) {
    echo 'selected';
} ?>><?php echo $group->title; ?></option>
                <?php }
                ?>

            </select>
        </div>
        <input type="hidden" name="old_group_id" value="<?php echo $row->group_id; ?>">
    <?php } ?>
    <input type="hidden" name="menu_id" value="<?php echo $row->id; ?>">
</form>