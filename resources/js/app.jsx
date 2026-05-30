import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import AiChat from './components/AiChat';
import DashboardAnalytics from './components/DashboardAnalytics';

// React chỉ mount khi trang Blade cung cấp đúng root element.
const dashboardRoot = document.getElementById('dashboard-analytics-root');

if (dashboardRoot) {
    // Dashboard nhận dữ liệu analytics đã serialize từ Blade.
    const dashboardData = JSON.parse(dashboardRoot.dataset.dashboard ?? '{}');
    const showLeaderboard = JSON.parse(dashboardRoot.dataset.showLeaderboard ?? 'false');

    createRoot(dashboardRoot).render(
        <React.StrictMode>
            <DashboardAnalytics
                statusBreakdown={dashboardData.statusBreakdown ?? {}}
                roleBreakdown={dashboardData.roleBreakdown ?? {}}
                departmentBreakdown={dashboardData.departmentBreakdown ?? []}
                categoryBreakdown={dashboardData.categoryBreakdown ?? []}
                topLecturers={dashboardData.topLecturers ?? []}
                showLeaderboard={showLeaderboard}
            />
        </React.StrictMode>,
    );
}

// AI chat cũng mount theo cách này, nhưng chỉ ở trang chat riêng.
const aiChatRoot = document.getElementById('ai-chat-root');

if (aiChatRoot) {
    const endpoint = aiChatRoot.dataset.endpoint ?? '/ai-chat';
    const conversationEndpoint = aiChatRoot.dataset.conversationEndpoint ?? '/ai-chat/conversations';
    const showEndpointTemplate = aiChatRoot.dataset.showEndpointTemplate ?? '/ai-chat/conversations/__CONVERSATION__';
    const bootstrap = JSON.parse(aiChatRoot.dataset.bootstrap ?? '{}');

    createRoot(aiChatRoot).render(
        <React.StrictMode>
            <AiChat
                endpoint={endpoint}
                conversationEndpoint={conversationEndpoint}
                showEndpointTemplate={showEndpointTemplate}
                bootstrap={bootstrap}
            />
        </React.StrictMode>,
    );
}
