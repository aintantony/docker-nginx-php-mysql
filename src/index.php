<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$users  = [];
$error  = null;

try {
    $pdo   = getDbConnection();
    $stmt  = $pdo->query('SELECT id, name, email, role, created_at FROM users ORDER BY id');
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = htmlspecialchars($e->getMessage());
}

$dbHost = getenv('DB_HOST') ?: 'mysql';
$dbName = getenv('DB_DATABASE') ?: 'appdb';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Docker · PHP · MySQL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Instrument Serif"', 'Georgia', 'serif'],
                        sans:  ['"DM Sans"', 'sans-serif'],
                        mono:  ['"DM Mono"', 'monospace'],
                    },
                    colors: {
                        parchment: { DEFAULT: '#f5f2ec', light: '#faf8f4' },
                        forest:    { DEFAULT: '#2d5a3d', light: '#e8f0eb', border: '#c5d9cb' },
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Mono:wght@400;500&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="font-sans bg-parchment min-h-screen px-6 py-12 text-stone-800">

<div class="max-w-4xl mx-auto">

    <header class="flex flex-wrap items-end justify-between gap-4 pb-7 mb-10 border-b border-stone-300">
        <div>
            <h1 class="font-serif text-5xl font-normal tracking-tight leading-none">
                Docker <em class="italic text-forest">Stack</em>
            </h1>
            <p class="mt-2 text-sm text-stone-400">Nginx &nbsp;·&nbsp; PHP-FPM &nbsp;·&nbsp; MySQL &mdash; live data demo</p>
        </div>
        <div class="flex flex-wrap gap-2 items-center">
            <span class="font-mono text-xs px-3 py-1 rounded border border-stone-300 bg-parchment-light text-stone-500 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-forest inline-block"></span>Nginx 1.25
            </span>
            <span class="font-mono text-xs px-3 py-1 rounded border border-stone-300 bg-parchment-light text-stone-500">
                PHP <?= PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION ?> FPM
            </span>
            <span class="font-mono text-xs px-3 py-1 rounded border border-stone-300 bg-parchment-light text-stone-500">
                <?= htmlspecialchars($dbName) ?>
            </span>
        </div>
    </header>

    <?php if ($error): ?>
        <div class="bg-orange-50 border border-orange-200 text-orange-900 px-5 py-3.5 rounded-md text-sm mb-6">
            <strong class="font-semibold">Database error:</strong> <?= $error ?>
        </div>
    <?php endif; ?>

    <div class="bg-parchment-light border border-stone-300 rounded-lg overflow-hidden shadow-sm">

        <div class="flex items-center justify-between px-6 py-3.5 border-b border-stone-200">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-stone-400">Users</h2>
            <span class="font-mono text-xs text-stone-400"><?= count($users) ?> rows</span>
        </div>

        <?php if ($users): ?>
        <table class="w-full border-collapse">
            <thead class="bg-parchment">
                <tr>
                    <?php foreach (['#', 'Name', 'Email', 'Role', 'Created'] as $col): ?>
                    <th class="px-6 py-2.5 text-left text-[0.65rem] font-semibold uppercase tracking-widest text-stone-400"><?= $col ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr class="border-t border-stone-200 hover:bg-stone-100/70 transition-colors">
                    <td class="px-6 py-3.5 font-mono text-xs text-stone-400"><?= (int) $u['id'] ?></td>
                    <td class="px-6 py-3.5 text-sm font-medium"><?= htmlspecialchars($u['name']) ?></td>
                    <td class="px-6 py-3.5 font-mono text-xs text-stone-500"><?= htmlspecialchars($u['email']) ?></td>
                    <td class="px-6 py-3.5">
                        <?php if ($u['role'] === 'admin'): ?>
                            <span class="inline-block px-2 py-0.5 rounded text-[0.68rem] font-semibold uppercase tracking-wider bg-stone-800 text-stone-100">
                                <?= htmlspecialchars($u['role']) ?>
                            </span>
                        <?php else: ?>
                            <span class="inline-block px-2 py-0.5 rounded text-[0.68rem] font-semibold uppercase tracking-wider bg-forest-light text-forest border border-forest-border">
                                <?= htmlspecialchars($u['role']) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-3.5 font-mono text-xs text-stone-400"><?= htmlspecialchars($u['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="px-6 py-10 text-center text-sm text-stone-400">No users found.</p>
        <?php endif; ?>

    </div>

    <footer class="mt-5 flex flex-wrap items-center justify-between gap-2 text-xs text-stone-400">
        <span>
            Connected to <code class="font-mono text-stone-500"><?= htmlspecialchars($dbHost) ?></code>
            / <code class="font-mono text-stone-500"><?= htmlspecialchars($dbName) ?></code>
        </span>
        <span>PHP <?= phpversion() ?></span>
    </footer>

</div>
</body>
</html>