package jp.ac.ait.k21231;

import java.util.Random;

import static java.util.Objects.isNull;

/**
 * 勇者クラス
 */
public class Hero extends CharacterBase {

    private Weapon weapon = null;// - 武器（このフィールドがnullの場合、武器は未装備状態とする）

    /**
     * 勇者の生成
     * 各ステータスを指定して初期化
     * @param name
     * @param hp
     * @param atk
     * @param def
     * @param agi
     */
    public Hero(String name, int hp, int atk, int def, int agi) {
        super(name, hp, atk, def, agi);
    }

    /**
     * 引数の相手に攻撃を行う
     * @param target
     * @return
     */
    @Override
    public AttackResult attack(CharacterBase target) {

        // 引数の攻撃対象に対して与えることのできるダメージを算出
        // 与えるダメージ = 自身の攻撃力 - 敵の防御力 / 2 (小数点以下切り上げ) に、-3〜+3のランダムな値を加算
        int damage = (int)Math.ceil((double)this.getAtk() - (target.getDef() / 2.0))
                + (new java.util.Random().nextInt(7) - 3); // ← −3〜+3のランダムな値

        // 素早さの比較値を取得
        int agiDiff = this.getAgi() - target.getAgi();
        int successRate = 100;  // 攻撃成功率 (初期値を100％としておく)

        if (agiDiff < 0) {
            // 遅い場合
            if (Math.abs(agiDiff) >= 5) {
                successRate = 60;   // 差が5以上: 60%
            } else {
                successRate = 70;   // 差が5未満: 70%
            }
        } else if (agiDiff == 0) {
            // 等速
            successRate = 80;   // 同じ場合: 80%
        } else {
            // 速い
            if (Math.abs(agiDiff) < 3) {
                successRate = 90;   // 差が3未満: 90%
            }
        }

        Random r = new Random();

        // 上記成功判定で攻撃が成功する(それ以外は失敗)
        if (r.nextInt(101) > successRate) { // 失敗判定
            AttackResult ret = new AttackResult();
            ret.damage = 0;   // ダメージ処理をしないで0を返す
            System.out.println("ミス！攻撃が当たらなかった。");
            return ret;
        }

        // 攻撃成功時 15% の確率でクリティカル
        if (r.nextInt(101) <= 15) {
            damage *= 2;
            System.out.println("クリティカル！ダメージが２倍。");
        }

        // 引数の攻撃対象がダメージを受ける
        boolean isBattleEnd = target.receiveDamage(damage);

        // 攻撃を行ったことによる行動結果を生成して返す
        AttackResult ret = new AttackResult();
        ret.damage = damage;
        if (isBattleEnd) {
            // 戦闘終了の条件を満たす場合、勇者の勝利となる
            ret.state = AttackResult.BATTLE_END;
        }
        return ret;
    }

    /**
     * 装備武器を返す
     * @return
     */
    public Weapon getWeapon() {
        return this.weapon;
    }

    /**
     * 装備武器を設定する
     * @param weapon
     */
    public void setWeapon(Weapon weapon) {
        this.weapon = weapon;
    }

    @Override
    public int getAtk() {
        //武器が未設定の場合は、変更する前と同じ値が返される。
        if(isNull(this.weapon)) {
            return super.getAtk();
        }
        //武器が設定されている場合は親クラスにて保持している攻撃力に加えて武器の攻撃力加算値を足して返すようにする。
        else{
            return super.getAtk() + this.weapon.getAtk();
        }
    }

}
