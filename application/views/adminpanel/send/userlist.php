<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='glyphicon glyphicon-th-list'></i><font color="red">【<?php echo $service_info['account_name'] ?>】</font><i class="fa fa-angle-double-right"></i>&nbsp;用户列表
        <div class='panel-tools'>

            <div class='btn-group'>
                <?php aci_ui_a($folder_name, 'service', 'index', '', ' class="btn  btn-sm "', '<span class="glyphicon glyphicon-arrow-left"></span> 返回') ?>
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
                    <input type="hidden" name="appid" value="<?php echo $appid; ?>"/>   
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
                        <th>昵称</th>
                        <th>头像</th>   
                        <th>性别</th>
                        <th>openid</th>
                        <th>是否关注</th>                      
                        <th>语言</th>
                        <th>所在国家</th>
                         <th>所在省份</th>
                        <th>所在城市</th>
                        <th>关注时间</th>
                        <th>备注</th>                        
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data_list as $k => $v): ?>
                        <tr>
                            <td><input type="checkbox" name="pid[]" value="<?php echo $v['user_id'] ?>"/></td>
                            <td><?php echo $v['user_id'] ?></td>
                            <td><i><?php echo $v['nickname'] ?></i></td>
                            <td>
                            <?php if($v['headimgurl']==''):?>
                               <i class="fa fa-image (alias)"></i>
                            <?php else:?>
                            <a href="<?php echo $v['headimgurl'] ?>" class="test-popup-link" target="__blank"><img src="<?php echo $v['headimgurl'] ?>" style="width:50px;" title="点击查看大图"></a>
                            <?php endif;?>                            
                            </td>
                             <td>
                             <?php if($v['sex']==1):?>
                            	 <i class="fa fa-mars"></i>
                             <?php elseif($v['sex']==2): ?>
                            	<i class="fa fa-venus"></i>
                             <?php else: ?>
                            	<i class="fa fa-venus-mars"></i>
                             <?php endif;?>
                             </td>
                            <td><?php echo $v['openid'] ?></td>                              
                             <td>
                            <?php if($v['subscribe']==1):?>
                               <font color="green"><i class="fa fa-check-circle"></i></font>                                
                            <?php else:?>
                              <font color="red"><i class="fa fa-close (alias)"></i></font>
                            <?php endif;?>                            
                            </td>                         
                            <td><?php echo $v['language'] ?></td>
                              <td><?php echo $v['country'] ?></td> 
                              <td><?php echo $v['province'] ?></td>  
                            <td><?php echo $v['city'] ?></td>                            
                            <td><?php echo $v['subscribe_time'] ?></td>
                            <td><?php echo $v['remark'] ?></td>                                
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">   
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
<link rel="stylesheet" href="<?php echo SITE_URL?>scripts/Magnific-Popup-master/dist/magnific-popup.css"/>
<script language="javascript" type="text/javascript">
    var folder_name = "<?php echo $folder_name?>";
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/index.js']);
        require(['<?php echo SITE_URL?>scripts/Magnific-Popup-master/dist/jquery.magnific-popup.min.js']);
    });
</script>