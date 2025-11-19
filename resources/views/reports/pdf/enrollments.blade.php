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
            border-bottom: 3px solid #7C3AED;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #7C3AED;
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
            background: #FAF5FF;
            border-left: 3px solid #7C3AED;
            margin-right: 10px;
        }

        .stat-box .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #7C3AED;
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
            background: #7C3AED;
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
            background: #FAFAFA;
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

        .status-confirmed {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-approved {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-cancelled, .status-rejected {
            background: #FEE2E2;
            color: #991B1B;
        }

        .status-waitlist {
            background: #E0E7FF;
            color: #3730A3;
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

        /* Email */
        .email-cell {
            color: #7C3AED;
            font-size: 9px;
        }

        /* Datas */
        .date-cell {
            white-space: nowrap;
            color: #4B5563;
            font-size: 9px;
        }

        /* Nome do usuário */
        .user-name {
            font-weight: bold;
            color: #1F2937;
        }

        /* Atividade/Projeto */
        .activity-cell {
            font-style: italic;
            color: #4B5563;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>Relatório de Inscrições</h1>
        <div class="subtitle">Registro completo de inscrições de usuários em atividades</div>

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
                <div class="meta-label">Total de Inscrições</div>
                <div class="meta-value">{{ count($rows) }} inscrições</div>
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
            <div class="stat-number">{{ $stats['confirmed'] ?? 0 }}</div>
            <div class="stat-label">Confirmadas</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $stats['pending'] ?? 0 }}</div>
            <div class="stat-label">Pendentes</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $stats['cancelled'] ?? 0 }}</div>
            <div class="stat-label">Canceladas</div>
        </div>
    </div>
    @endif

    <!-- Tabela -->
    <div class="table-container">
        <div class="section-title">Listagem Detalhada de Inscrições</div>

        <table>
            <thead>
                <tr>
                    <th style="width: 6%">ID</th>
                    <th style="width: 18%">Usuário</th>
                    <th style="width: 20%">Email</th>
                    <th style="width: 20%">Atividade</th>
                    <th style="width: 15%">Projeto</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 11%">Criado em</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $en)
                    <tr>
                        <td class="id-cell">#{{ $en->id }}</td>
                        <td class="user-name">{{ $en->user->name ?? '—' }}</td>
                        <td class="email-cell">{{ $en->user->email ?? '—' }}</td>
                        <td class="activity-cell">{{ $en->activity->title ?? '—' }}</td>
                        <td>{{ optional($en->activity->project)->title ?? '—' }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($en->status) }}">
                                {{ ucfirst($en->status) }}
                            </span>
                        </td>
                        <td class="date-cell">{{ \Carbon\Carbon::parse($en->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #9CA3AF;">
                            Nenhuma inscrição encontrada para o período selecionado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Resumo por Status (opcional) -->
    @if(isset($status_summary) && count($status_summary) > 0)
    <div style="margin-top: 25px; padding: 15px; background: #F9FAFB; border-radius: 8px;">
        <div style="font-weight: bold; margin-bottom: 10px; color: #1F2937; font-size: 12px;">Resumo por Status:</div>
        <div style="display: table; width: 100%;">
            @foreach($status_summary as $status => $count)
            <div style="display: table-cell; padding: 5px 10px;">
                <span class="status-badge status-{{ strtolower($status) }}">{{ ucfirst($status) }}</span>
                <span style="margin-left: 5px; font-weight: bold;">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Rodapé -->
    <div class="footer">
        <div>Este documento foi gerado automaticamente pelo sistema em {{ now()->format('d/m/Y') }} às {{ now()->format('H:i') }}</div>
        <div class="page-number">Página 1 de 1</div>
    </div>
</body>
</html>
