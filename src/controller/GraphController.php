<?php

class GraphController extends Controller
{
    // 初回アクセス時にHTMLの描画を行う
    public function index(): array
    {
        $content = $this->render();
        return ['content' => $content];
    }

    // 初回アクセス時に自動で送られてきた非同期処理に対してレスポンスデータを取得する
    public function init(): array
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $responseData = $this->service->init();

        return $responseData;
    }

    // ユーザーからの検索リクエストを非同期で受け取りレスポンスデータを取得する
    public function search(): array
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $requestData = $this->request->getRequestData();
        return $this->service->search($requestData);
    }
}
