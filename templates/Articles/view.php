<h1><?= h($article->title) ?></h1>
<p><?= h($article->body) ?></p>
<p><small>Cr�� le : <?= $article->created->format(DATE_RFC850) ?></small></p>
<p><?= $this->Html->link('Modifier', ['action' => 'edit', $article->slug]) ?></p>