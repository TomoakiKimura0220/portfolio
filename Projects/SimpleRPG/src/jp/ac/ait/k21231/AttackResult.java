package jp.ac.ait.k21231;

/**
 * 行動後の戻り値
 * 構造体のように扱いたいからpublic
 */
public class AttackResult {
    public static final int BATTLE_END = 1;
    public static final int CONTINUE = 0;//攻撃アクション後に続くかのフラグ
    /**
     * 攻撃によって与えたダメージ
     */
    public int damage = 0;
    /**
     * アクション後の戦闘状態
     * 初期値は継続とする
     */
    public int state = CONTINUE;
}
