    <h1>({$info.user_id}) {$info.username} Lv. {$info.level}</h1>

<p class="list-padding-top">
  <ul>
    <li class="list">{$property.language.exp}: {$info.experience}/{$info.exp_next_level}</li>
    <li class="list">{$property.language.hp}: {$info.hp}/{$info.max_hp}</li>
    <li class="list">{$property.language.mp}: {$info.mp}/{$info.max_mp}</li>
    <li class="list">{$property.language.fatigue}: {$info.tireness}/100</li>
    <li class="list">{$property.language.hunger}: {$info.hunger}/100</li>
    <li class="list">{$property.language.energy}: {$info.energy}/{$info.max_energy}</li>
    <li class="list">{$property.language.spyLevel}: {$info.spy_level}</li>
    <li class="list">{$property.language.energyBank}: {$info.banked_energy}</li>
    <li class="list">{$property.language.copper}: <span id="statCopper">{$info.copper}</span></li>
    <li class="list">{$property.language.copperBank}: {$info.bank}</li>
    <li class="list">{$property.language.points}: {$info.points}</li>
    <li class="list"><a href="{$WEB_ROOT}/tale/hospital">{$property.language.hospital}</a></li>
    <li class="list">{$property.language.mail} (0)</li>
    <li class="list">{$property.language.log} (0)</li>
    <li class="list">{$property.language.myProfile}</li>
  </ul>
</p>