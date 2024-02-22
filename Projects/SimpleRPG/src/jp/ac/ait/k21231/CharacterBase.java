package jp.ac.ait.k21231;

public abstract class CharacterBase {
    private String name; // - 名前
    private int hp; // - 体力
    private int atk; // - 攻撃力
    private int def; // - 防御力
    private int agi; // - 素早さ

    /**
     * 勇者の生成
     * 各ステータスを指定して初期化
     * @param name
     * @param hp
     * @param atk
     * @param def
     * @param agi
     */
    public CharacterBase(String name, int hp, int atk, int def, int agi) {
        // それぞれ引数の値で初期値セット
        this.name = name;
        this.hp = hp;
        this.atk = atk;
        this.def = def;
        this.agi = agi;
    }

    public String getName() {
        return name;
    }

    public int getHp() {
        return hp;
    }

    public int getAtk() {
        return atk;
    }

    public int getDef() {
        return def;
    }

    public int getAgi() {
        return agi;
    }

    public void setAtk(int atk) {
        this.atk = atk;
    }

    /**
     * 攻撃
     * @param target
     * @return
     */
    public abstract AttackResult attack(CharacterBase target);

    /**
     * ダメージを受ける
     * @param damage 受けるダメージ量
     * @return 戦闘続行可能な場合 false , 不可能な場合 true
     */
    public boolean receiveDamage(int damage) {
        // 勇者がダメージを受ける。(自分で呼び出さず、敵であるEnemyから呼ばれる)

        // フィールドのhpから引数のダメージ分を減算し、
        this.hp -= damage;

        // 0を下回る場合はhpに0を代入する。
        if (this.hp <= 0) {
            this.hp = 0;
            // 戻り値はダメージを受けたあとのHPが0以下の場合trueを返し、戦闘続行不可能とする。
            return true;
        }

        //減少後のhpを表示
        System.out.println(getName() + " : HP " + getHp());

        // HPはまだ残っているので、戦闘は続行
        return false;
    }

    @Override
    public String toString() {
        return String.format("%s : HP %d, ATK %d, DEF %d, AGI %d",
                this.name, this.hp, this.atk, this.def, this.agi);
    }
}
