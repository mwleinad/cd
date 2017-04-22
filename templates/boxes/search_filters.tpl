
          <div class="divSearch">
          {$property.language.ordenByLevel}: 
          <span id="spanOrder{$property.language.asc}" class="spanOrderFilter" style="cursor:pointer;{if $session.order == $property.language.asc}font-weight:bold{/if}">{$property.language.asc}</span> | 
          <span id="spanOrder{$property.language.desc}" class="spanOrderFilter" style="cursor:pointer;{if $session.order == $property.language.desc}font-weight:bold{/if}">{$property.language.desc}</span>
          </div>
          <div class="divSearch">
          {$property.language.raceFilter}: 
          {foreach from=$races item=race}
          	<span id="spanRace{$race}" class="spanRaceFilter" style="cursor:pointer;{if $session.race == $race}font-weight:bold{/if}">{$race}</span> | 
          {/foreach}
          	<span id="spanRaceAll" class="spanRaceFilter" style="cursor:pointer;{if $session.race == {$property.language.all}}font-weight:bold{/if}">{$property.language.all}</span>
          </div>
          <div class="divSearch">
          {$property.language.elementFilter}: 
          {foreach from=$elements item=element}
          	<span id="spanElement{$element}" class="spanElementFilter" style="cursor:pointer;{if $session.element == $element}font-weight:bold{/if}">{$element}</span> | 
          {/foreach}
          	<span id="spanElementAll" class="spanElementFilter" style="cursor:pointer;{if $session.element == {$property.language.all}}font-weight:bold{/if}">{$property.language.all}</span>
          </div>
          <div class="divSearch">
          {$property.language.cityFilter}: 
          {foreach from=$cities item=city}
          <span id="spanCity{$city.CityName}" class="spanCityFilter" style="cursor:pointer;{if $session.city == $city.CityName}font-weight:bold{/if}">{$city.CityName}</span> |
          {/foreach}
          <span id="spanCityAll" class="spanCityFilter" style="cursor:pointer;{if $session.city == $property.language.all}font-weight:bold{/if}">{$property.language.all}</span>
          </div>
          <div class="divSearch">
          {$property.language.genderFilter}: 
          {foreach from=$genders item=gender}
          <span id="spanGenderAll" class="spanGenderFilter" style="cursor:pointer;{if $session.gender == $gender}font-weight:bold{/if}">{$gender}</span> |
          {/foreach}
          <span id="spanGenderAll" class="spanGenderFilter" style="cursor:pointer;{if $session.gender == $property.language.all}font-weight:bold{/if}">{$property.language.all}</span>
          </div>
          <div class="divSearch">
          {$property.language.statusFilter}: 
          <span id="spanStatusAlive" class="spanStatusFilter" style="cursor:pointer;{if $session.status == {$property.language.alive}}font-weight:bold{/if}">{$property.language.alive}</span>| 
          <span id="spanStatusDead" class="spanStatusFilter" style="cursor:pointer;{if $session.status == {$property.language.dead}}font-weight:bold{/if}">{$property.language.dead}</span> | 
          <span id="spanStatusAll" class="spanStatusFilter" style="cursor:pointer;{if $session.status == {$property.language.all}}font-weight:bold{/if}">{$property.language.all}</span>
          </div>
          <div class="divSearch">
          {include file="{$DOC_ROOT}/templates/forms/search.tpl"}  
          </div>