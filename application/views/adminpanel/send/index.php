<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='glyphicon glyphicon-th-list'></i> 群发列表
        <div class='panel-tools'>

            <div class='btn-group'>
                <?php aci_ui_a($folder_name, 'send', 'add', '', ' class="btn  btn-sm "', '<span class="glyphicon glyphicon-plus"></span> 推送消息') ?>
            </div>
            <div class='badge'><?php echo count($data_list) ?></div>
        </div>
    </div>
    <div class='panel-filter '>
        <form class="form-inline" role="form" method="get">
            <div class="form-group">
                <label for="keyword" class="form-control-static control-label">关键词</label>
                <input class="form-control" type="text" name="keyword" value="<?php echo $keyword; ?>" id="keyword"
                       placeholder="请输入关键词"/></div>
            <button type="submit" name="dosubmit" value="搜索" class="btn btn-success"><i
                    class="glyphicon glyphicon-search"></i></button>   
        </form>
    </div>
    <form method="post" id="form_list">

        <?php if ($data_list): ?>
            <div class='panel-body '>
                <table class="table table-hover dataTable">
                    <thead>
                    <tr>
                        <th><font color="gold"><i class="fa fa-star"></i></font></th>
                        <th>编号</th>
                        <th>公众号名称</th>
                        <th>模板编号</th>
                        <th>关键词1</th>
                        <th>关键词2</th>
                        <th>关键词3</th>
                        <th>推送状态</th>
                        <th>更新时间</th>                        
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data_list as $k => $v): ?>
                        <tr>
                            <td><input type="checkbox" name="pid[]" value="<?php echo $v['id'] ?>"/></td>
                            <td><?php echo $v['id'] ?></td>
                            <td><?php echo $v['account_name'] ?></td>
                            <td><i><?php echo $v['temp_id'] ?></i></td>
                            <td><?php echo $v['keyword1'] ?></td>
                            <td><?php echo $v['keyword2'] ?></td>
                            <td><?php echo $v['keyword3'] ?></td>                      
                            <td>
                            <?php if($v['push_status']==1): ?>
                             <font color="green"><i class="fa fa-check"></i></font>
                             <?php else:?>
                             <font color="red"><i class="fa fa-close (alias)"></i></font>
                            <?php endif; ?>
                            </td>
                           <td><?php echo $v['update_time'] ?></td>   
                            <td>
                             <?php if($v['push_status']==0): ?>
                                <?php aci_ui_a($folder_name, 'send', 'edit', $v['id'], ' class="btn btn-danger btn-xs"', '<span class="glyphicon glyphicon-repeat"></span> 重新推送') ?>
                                <?php else:?>
                                <?php aci_ui_a($folder_name, 'send', 'browser', $v['id'], ' class="btn btn-info btn-xs"', '<span class="glyphicon glyphicon-eye-close"></span>查看明细') ?>                                
                                <?php endif; ?>
                            </td>                        
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

            <div class="panel-footer">
                <div class="pull-left">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="reverseBtn"><span
                                class="glyphicon glyphicon-ok"></span> 反选
                        </button>
                        <?php aci_ui_button($folder_name, 'send', 'delete', ' class="btn btn-default" id="deleteBtn" ', '<span class="glyphicon glyphicon-remove"></span> 删除勾选') ?>
                    </div>
                </div>
                <div class="pull-right">
                    <?php echo $pages; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-warning" role="alert"> 暂无数据显示... 您可以进行新增操作</div>
        <?php endif; ?>
    </form>
</div>
</div>

<script language="javascript" type="text/javascript">
    var folder_name = "<?php echo $folder_name?>";
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/index.js']);
    });
</script>