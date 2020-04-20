
  <!-- 検索数を表示 -->
  <p class="p-counter__right">
    {{ $tasks->firstItem() }} 〜
    {{ $tasks->lastItem() }} ／
    <a class="p-counter__total">{{ $tasks->total() }} 件</a>
  </p>
