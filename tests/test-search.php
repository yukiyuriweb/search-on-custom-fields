<?php
/**
 * Class SampleTest
 *
 * @package Search_On_Custom_Fields
 */

/**
 * Search test case.
 */
class SearchTest extends WP_UnitTestCase {
    /**
     * A single example test.
     */
    public function test_search() {
        $post = $this->factory->post->create_and_get([
            'post_title' => 'test title',
            'post_content' => 'test content'
        ]);

        $id = $post->ID;

        // 今日の日付 (YYYY-MM-DD) を取得する.
        $today = explode(' ', current_time('mysql'))[0];
        $meta_value = $today;

        // カスタムフィールド period を追加する.
        update_post_meta($id, 'period', $meta_value);
        $this->assertEquals(get_post_meta($id, 'period', true), $meta_value);

        // 検索結果でカスタムフィールドでの検索が追加されている.
        $this->go_to(get_search_link($meta_value));
        $this->assertTrue(have_posts());

        // カスタムフィールドにないクエリで検索を行うと検索結果が空になっている.
        $this->go_to(get_search_link('2000-01-01'));
        $this->assertFalse(have_posts());
    }
}
