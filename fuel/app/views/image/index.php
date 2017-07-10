<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('drag-and-drop.css'); ?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<?php echo Asset::js('drag-and-drop.js'); ?>
</head>
<body onload="start()">
<div id="loader-bg">
	<div id="loader">
		<?php echo Asset::img('img-loading.gif'); ?>
		<p style="color: white">Now Loading...</p>
	</div>
</div>
<h1>画像圧縮くん( 'ω')</h1>
<hr size="4">
<?php
	echo Form::open(array('action' => 'image/resize_and_crop', 'method' => 'post', 'enctype' => 'multipart/form-data'));
?>
<p id="response"></p>
<div id="dropto">ファイルをここにドロップ</div>
<div id="progress">
	<div id="percent">
	</div>
</div>
<div align="center">
	または<input name="userfile" type="file" id="input-file">
	<input style="display: block;" type="button" value="アップロード" id="upload" disabled />
	<div id="state"></div>
</div>
<?php
	echo Form::close();
?>

<?php
	echo Form::open(array('action' => 'image/regist_resize', 'method' => 'post'));
?>
<div style="background: pink;" align="center">
	<table style="border-style: solid; margin-top: 10px;">
		<tbody>
			<tr>
				<td>圧縮したいサイズ、ダウンロード枚数を入力してください</td>
			</tr>
			<tr>
				<td>width: <input type="text" name="width"> height: <input type="text" name="height"> 数: <input type="text" name="num"></td>
			</tr>
			<?php
				foreach($compression_info as $id => $r)
				{
					?>
					<tr>
						<td>
							<table style="border: 1px solid black;" align="center">
								<tbody>
								<tr id="row">
									<td style="border: 1px solid black; width: 100px;">
										<?php echo $r['id']; ?>.
									</td>
									<td style="border: 1px solid black; width: 100px;">
										width: <?php echo $r['width']; ?>
									</td>
									<td style="border: 1px solid black; width: 100px;">
										height: <?php echo $r['height']; ?>
									</td>
									<td style="border: 1px solid black; width: 100px;">
										数: <?php echo $r['num']; ?>
									</td>
									<td style="border: 1px solid black; width: 20px; height: 20px; position: relative;">
										<div id="cancel_btn_<?php echo $r['id']; ?>">
											<input type="hidden" value="<?php echo $r['id']; ?>">
										</div>
									</td>
								</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<?php
				}
			?>
			<!-- DBから取得してきた登録圧縮サイズ一覧を表示 -->
			<tr>
				<td><input type="submit" value="追加"></td>
			</tr>
		</tbody>
	</table>
</div>
<?php
	echo Form::close();
?>

<script>
	$("[id^='cancel_btn_']").each(function(){
		this.addEventListener('click', function(){
			var param = "id=" + $(this).children('input').get(0).value;
			var xhr = new XMLHttpRequest();
			xhr.onload = function(e){
				console.log("成功");
				var cancelBtn = '#cancel_btn_' + JSON.parse(this.response)['delete_id'];
				console.log($(cancelBtn).parent().find("tr"));
				$(cancelBtn).parent().parent().fadeOut('fast').queue(function(){
					this.remove();
				});
			};
			xhr.onerror = function(e){
				console.log("失敗");
			};
			xhr.open('POST', '/image/delete', true);
			// サーバー側での処理方法指定
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send(param);
		});
	});
</script>
</body>
</html>
