package jp.ac.ait.k21231;

/**
 * 敵クラス
 */
public class Enemy extends CharacterBase {

    /**
     * 各ステータスを指定して初期化
     * @param name
     * @param hp
     * @param atk
     * @param def
     * @param agi
     */
    public Enemy(String name, int hp, int atk, int def, int agi) {
        super(name, hp, atk, def, agi);
    }

    @Override
    public AttackResult attack(CharacterBase target) {
        // 敵に対して攻撃を行う処理を実装します。

        // 引数の攻撃対象targetに対して与えることのできるダメージを算出
        // 与えるダメージ = 自身の攻撃力 - 敵の防御力 / 2 (小数点以下切り上げ) に、-3〜+3のランダムな値を加算
        int damage = (int)Math.ceil((double)this.getAtk() - (target.getDef() / 2.0))
                + (new java.util.Random().nextInt(7) - 3); // ← −3〜+3のランダムな値

        // 与えるダメージの計算式に従って計算されたダメージ量を引数の相手に与えます。
        boolean isBattleEnd = target.receiveDamage(damage);

        // 戻り値は、AttackResultのインスタンスを生成し、ダメージ量と戦闘続行かどうかの状態をAttackResultの定数フィールドを使って設定して返します。
        AttackResult ret = new AttackResult();
        ret.damage = damage;
        if (isBattleEnd) {  // 戦闘が終わる場合により詳細な状態を渡したい
            ret.state = AttackResult.BATTLE_END;
        } // CONTINUE は初期値なので、ENDの場合のみ設定すればOK
        return ret;
    }
}
