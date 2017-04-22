        <div class="form">
          <form method="post" name="searchByIdForm" id="searchByIdForm">
            <input type="hidden" name="action" value="searchById">
            <fieldset>
              <div class="formLine">
                <label for="id" >{$property.language.id}</label>
                <input class="textfield" type="text" size='15' name="id" id="id" value="1">
                <input type="button" id="byId" name="byId" class="buttonForm" value="{$property.language.search}!" />
							</div>
							</fieldset>
          </form>
          <form method="post" name="searchByUsername" id="searchByUsername">
            <input type="hidden" name="action" value="searchByUsername">
              <div class="formLine">
                <label for="id" >{$property.language.username}</label><input class="textfield" type="text" size='15' name="username" id="username" value=""> <input name="byUsername" id="byUsername" class="buttonForm" type="button" value="{$property.language.search}">
              </div>
            </fieldset>
          </form>
        </div>	<!--- end form -->
