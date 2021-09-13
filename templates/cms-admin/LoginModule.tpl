<form class="form-horizontal" method="post" action="{$oMod->getBasePage($oMod->getModule())}">
	<fieldset>
		<legend>
			Please login first !
		</legend>
		<div class="control-group">
			<label for="username" class="control-label">{loc k=username}</label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="username" id="username"/>
			</div>
		</div>
		<div class="control-group">
			<label for="password" class="control-label">{loc k=password}</label>
			<div class="controls">
				<input type="password" class="input-xlarge" name="password" id="password"/>
			</div>
		</div>
		<div class="form-actions">
			<button class="btn btn-primary" type="submit" name="login" value="1">
				{loc k=login}
			</button>
		</div>
	</fieldset>
</form>