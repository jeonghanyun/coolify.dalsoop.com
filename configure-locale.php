<?php
/**
 * WordPress 한국어 설정 및 타임존 설정 스크립트
 *
 * 이 스크립트는 WordPress를 한국어로 설정하고 Asia/Seoul 타임존으로 변경합니다.
 */

// WordPress 환경 로드
require_once('/var/www/html/wp-load.php');

echo "=== WordPress 한국어 및 타임존 설정 시작 ===\n\n";

// 1. 언어 설정
echo "1. 한국어 언어팩 다운로드 중...\n";
require_once(ABSPATH . 'wp-admin/includes/translation-install.php');

$language = 'ko_KR';
$downloaded = wp_download_language_pack($language);

if ($downloaded) {
    echo "   ✓ 한국어 언어팩 다운로드 완료: $downloaded\n";
} else {
    echo "   ⚠ 언어팩이 이미 설치되어 있거나 다운로드에 실패했습니다.\n";
}

// WPLANG 옵션 설정
update_option('WPLANG', $language);
echo "   ✓ 사이트 언어를 한국어(ko_KR)로 설정했습니다.\n\n";

// 2. 타임존 설정
echo "2. 타임존 설정 중...\n";
update_option('timezone_string', 'Asia/Seoul');
update_option('gmt_offset', 9);
echo "   ✓ 타임존을 Asia/Seoul(UTC+9)로 설정했습니다.\n\n";

// 3. 날짜/시간 형식 설정
echo "3. 날짜 및 시간 형식 설정 중...\n";
update_option('date_format', 'Y년 m월 d일');
update_option('time_format', 'H:i');
update_option('start_of_week', '0'); // 일요일
echo "   ✓ 날짜 형식: Y년 m월 d일\n";
echo "   ✓ 시간 형식: H:i (24시간)\n";
echo "   ✓ 한 주의 시작: 일요일\n\n";

// 4. 설정 확인
echo "=== 현재 설정 확인 ===\n";
echo "사이트 언어: " . get_option('WPLANG') . "\n";
echo "타임존: " . get_option('timezone_string') . " (GMT+" . get_option('gmt_offset') . ")\n";
echo "날짜 형식: " . get_option('date_format') . "\n";
echo "시간 형식: " . get_option('time_format') . "\n";
echo "한 주의 시작: " . (get_option('start_of_week') == 0 ? '일요일' : '월요일') . "\n\n";

// 5. 현재 시간 표시 (테스트)
echo "=== 현재 시간 (설정 적용 확인) ===\n";
echo "현재 시간: " . current_time('Y년 m월 d일 H:i:s') . "\n";
echo "GMT 시간: " . gmdate('Y-m-d H:i:s') . "\n\n";

echo "=== 설정 완료 ===\n";
echo "WordPress가 한국어 및 Asia/Seoul 타임존으로 설정되었습니다.\n";
echo "관리자 페이지(http://localhost/wp-admin)에서 확인하세요.\n";
