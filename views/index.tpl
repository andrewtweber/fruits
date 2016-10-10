{if $_PAGE['id'] != 'all'}
<nav>
	<a href="/{$prev}">&lsaquo; {substr(ucwords($prev), 0, 3)}<span>{substr($prev, 3)}</span></a>
	<a href="/all">All<span> Fruits</span></a>
	<a href="/{$next}">{substr(ucwords($next), 0, 3)}<span>{substr($next, 3)}</span> &rsaquo;</a>
	
	<div class="break"></div>
</nav>
{/if}

{foreach $fruits as $fruit}
<a class="{if $smaller}small {/if}fruit" href="/{$fruit['url']}">
	<img src="/images/fruits/{if $smaller}small/{/if}{$fruit['url']}.{if $smaller}png{else}jpg{/if}" width="320" height="320" alt="{$fruit['plural_name']}">

	<span>{$fruit['plural_name']}</span>
</a>
{if $smaller}
<div class="break"></div>
{/if}
{/foreach}

<div class="break"></div>
