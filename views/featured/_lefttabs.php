<div class="h-100"> <!-- Make the entire right-side tab a card to match the left -->
    <ul class="nav nav-tabs" id="insight" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="insight-prof-tab" data-bs-toggle="tab" data-bs-target="#insight-prof" type="button" role="tab" aria-controls="profile" aria-selected="false">Pro Insight</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="insight-ai-tab" data-bs-toggle="tab" data-bs-target="#insight-ai" type="button" role="tab" aria-controls="home" aria-selected="true">AI Insight</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ai-talk-tab" data-bs-toggle="tab" data-bs-target="#ai-talk" type="button" role="tab" aria-controls="home" aria-selected="true">AI Talk</button>
        </li>
    </ul>
    <div class="tab-content p-3 card" id="insightContent">
        <div class="tab-pane fade show active" id="insight-prof" role="tabpanel" aria-labelledby="insight-prof-tab" style="height: calc(100% - 40px);">
            It is a long established fact that a reader will be distracted...
        </div>

        <div class="tab-pane fade insight-ai"
            id="insight-ai" role="tabpanel" aria-labelledby="insight-ai-tab" style="height: calc(100% - 40px);">

            <!-- Button Container -->
            <div id="button-container" class="text-center">
                <button id="create-ai-insight" class="btn-sm btn btn-outline-secondary mb-2 fst-italic">Klik untuk Lihat AI-Generated Insight</button>
            </div>

            <!-- Loading Bar (initially hidden) -->
            <div id="loading-bar" class="text-center" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <!-- Insight Content (initially hidden) -->
            <div id="insight-content" style="display: none;"></div>
        </div>

        <div class="tab-pane fade" id="ai-talk" role="tabpanel" aria-labelledby="ai-talk-tab">
            <div class="chat-container">
                <div id="chat-log" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                </div>
                <div>
                    <textarea id="user-input" class="form-control" placeholder="Type 'tes' to run this chat..." rows="3"></textarea>
                </div>
                <div class="d-flex flex-row-reverse">
                    <div>
                        <button id="send-btn" class="btn btn-primary btn-sm" style="margin-top: 10px;">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>