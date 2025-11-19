<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.6;
            padding: 30px;
        }

        /* Cabeçalho */
        .header {
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #4F46E5;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header .subtitle {
            color: #6B7280;
            font-size: 12px;
        }

        .header .meta {
            margin-top: 15px;
            display: table;
            width: 100%;
        }

        .header .meta-item {
            display: table-cell;
            padding: 8px 12px;
            background: #F3F4F6;
            border-radius: 4px;
            margin-right: 10px;
        }

        .header .meta-label {
            font-weight: bold;
            color: #4B5563;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header .meta-value {
            color: #1F2937;
            font-size: 11px;
            margin-top: 2px;
        }

        /* Estatísticas */
        .stats {
            margin-bottom: 25px;
            display: table;
            width: 100%;
        }

        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            background: #F9FAFB;
            border-left: 3px solid #4F46E5;
            margin-right: 10px;
        }

        .stat-box .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 3px;
        }

        .stat-box .stat-label {
            font-size: 10px;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Tabela */
        .table-container {
            margin-top: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1F2937;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #E5E7EB;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead tr {
            background: #4F46E5;
            color: white;
        }

        th {
            padding: 10px 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        tbody tr {
            border-bottom: 1px solid #E5E7EB;
        }

        tbody tr:nth-child(even) {
            background: #F9FAFB;
        }

        tbody tr:hover {
            background: #F3F4F6;
        }

        td {
            padding: 10px 8px;
            font-size: 10px;
            color: #374151;
            border: none;
        }

        /* Badge de Status */
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-completed {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* Rodapé */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
            font-size: 9px;
        }

        .footer .page-number {
            margin-top: 5px;
        }

        /* IDs e números */
        .id-cell {
            font-family: monospace;
            color: #6B7280;
            font-weight: bold;
        }

        /* Datas */
        .date-cell {
            white-space: nowrap;
            color: #4B5563;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>Relatório de Atividades</h1>
        <div class="subtitle">Documento gerado automaticamente pelo sistema</div>

        <div class="meta">
            <div class="meta-item">
                <div class="meta-label">Data de Geração</div>
                <div class="meta-value">{{ now()->format('d/m/Y H:i') }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Período</div>
                <div class="meta-value">
                    @if(isset($start_date) && isset($end_date))
                        {{ $start_date }} até {{ $end_date }}
                    @else
                        Todos os registros
                    @endif
                </div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Total de Registros</div>
                <div class="meta-value">{{ count($rows) }} atividades</div>
            </div>
        </div>
    </div>

    <!-- Estatísticas (opcional - calcular no controller) -->
    @if(isset($stats))
    <div class="stats">
        <div class="stat-box">
            <div class="stat-number">{{ $stats['total'] ?? count($rows) }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $stats['active'] ?? 0 }}</div>
            <div class="stat-label">Ativas</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $stats['completed'] ?? 0 }}</div>
            <div class="stat-label">Concluídas</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $stats['pending'] ?? 0 }}</div>
            <div class="stat-label">Pendentes</div>
        </div>
    </div>
    @endif

    <!-- Tabela -->
    <div class="table-container">
        <div class="section-title">Listagem Detalhada</div>

        <table>
            <thead>
                <tr>
                    <th style="width: 8%">ID</th>
                    <th style="width: 25%">Título</th>
                    <th style="width: 18%">Projeto</th>
                    <th style="width: 12%">Início</th>
                    <th style="width: 12%">Término</th>
                    <th style="width: 12%">Status</th>
                    <th style="width: 13%">Criado em</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                    <tr>
                        <td class="id-cell">#{{ $row->id }}</td>
                        <td><strong>{{ $row->title }}</strong></td>
                        <td>{{ optional($row->project)->title ?? '—' }}</td>
                        <td class="date-cell">{{ $row->start_date ? \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') : '—' }}</td>
                        <td class="date-cell">{{ $row->end_date ? \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') : '—' }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($row->status) }}">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                        <td class="date-cell">{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #9CA3AF;">
                            Nenhuma atividade encontrada para o período selecionado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <div>Este documento foi gerado automaticamente pelo sistema em {{ now()->format('d/m/Y') }} às {{ now()->format('H:i') }}</div>
        <div class="page-number">Página 1 de 1</div>
    </div>
</body>
</html>
